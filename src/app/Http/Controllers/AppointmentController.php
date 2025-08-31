<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\HealthcareProfessional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $appointments = Appointment::with('professional')
            ->where('user_id', $request->user()->id)
            ->orderBy('appointment_start_time', 'desc')
            ->get();

        return response()->json($appointments);
    }

    public function store(StoreAppointmentRequest $request)
    {
        $user = $request->user();

        $validated = $request->validated();
        $professionalId = $validated['healthcare_professional_id'];
        $start = $validated['appointment_start_time'];
        $end = $validated['appointment_end_time'];

        // Ensure professional exists
        $professional = HealthcareProfessional::findOrFail($professionalId);

        // Transaction + FOR UPDATE to prevent race double-booking
        $appointment = DB::transaction(function () use ($user, $professionalId, $start, $end) {

            // Lock potential overlapping rows for this professional
            $overlapExists = Appointment::where('healthcare_professional_id', $professionalId)
                ->where('status', 'booked')
                ->where(function ($q) use ($start, $end) {
                    $q->whereBetween('appointment_start_time', [$start, $end])
                      ->orWhereBetween('appointment_end_time', [$start, $end])
                      ->orWhere(function ($q2) use ($start, $end) {
                          $q2->where('appointment_start_time', '<=', $start)
                             ->where('appointment_end_time', '>=', $end);
                      });
                })
                ->lockForUpdate()
                ->exists();

            if ($overlapExists) {
                throw ValidationException::withMessages([
                    'appointment_start_time' => ['The selected time overlaps with another booking.'],
                ]);
            }

            return Appointment::create([
                'user_id'=> $user->id,
                'healthcare_professional_id'=> $professionalId,
                'appointment_start_time'=> $start,
                'appointment_end_time'=> $end,
                'status'=> 'booked',
            ]);
        });

        return response()->json($appointment, 201);
    }

    public function cancel(Request $request, Appointment $appointment)
    {
        Gate::authorize('cancel', $appointment);

        if ($appointment->status !== 'booked') {
            throw ValidationException::withMessages([
                'status' => ['Only booked appointments can be cancelled.'],
            ]);
        }

        $hoursDiff = now()->diffInHours($appointment->appointment_start_time, false);

        if ($hoursDiff < 24) {
            throw ValidationException::withMessages([
                'appointment_start_time' => ['Cannot cancel within 24 hours of the appointment.'],
            ]);
        }

        $appointment->status = 'cancelled';
        $appointment->save();

        return response()->json(['message' => 'Appointment cancelled.']);
    }
}
