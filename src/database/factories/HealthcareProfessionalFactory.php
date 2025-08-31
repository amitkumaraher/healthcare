<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class HealthcareProfessionalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

$specialties = [
    'General Practitioner',
    'Family Medicine Physician',
    'Pediatrician',
    'Geriatrician',
    'Internal Medicine Physician',
    'General Surgeon',
    'Orthopedic Surgeon',
    'Neurosurgeon',
    'Cardiothoracic Surgeon',
    'Plastic Surgeon',
    'Vascular Surgeon',
    'Urologist',
    'Otolaryngologist (ENT)',
    'Ophthalmologist',
    'Radiologist',
    'Anesthesiologist',
    'Pathologist',
    'Nuclear Medicine Physician',
    'Cardiologist',
    'Dermatologist',
    'Endocrinologist',
    'Gastroenterologist',
    'Nephrologist',
    'Neurologist',
    'Pulmonologist',
    'Rheumatologist',
    'Oncologist',
    'Hematologist',
    'Infectious Disease Specialist',
    'Allergist/Immunologist',
    'Psychiatrist',
    'Physiatrist (Physical Medicine & Rehabilitation)',
    'Physical Therapist',
    'Occupational Therapist',
];

        return [
            'name' => 'Dr. ' . fake()->firstName() . ' ' . fake()->lastName(),
            'specialty' => fake()->randomElement($specialties),
        ];
    }
}
