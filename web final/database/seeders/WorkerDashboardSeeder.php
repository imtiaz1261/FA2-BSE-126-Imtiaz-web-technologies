<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Earning;
use App\Models\Message;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkerActivity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WorkerDashboardSeeder extends Seeder
{
    public function run(): void
    {
        $worker = User::updateOrCreate(
            ['email' => 'worker@demo.com'],
            [
                'name' => 'Ali Raza',
                'password' => Hash::make('password'),
                'role' => 'worker',
                'category' => 'Electrical',
                'experience' => 5,
                'hourly_rate' => 45,
                'address' => 'Gulberg, Lahore',
                'lat' => 31.5204,
                'lng' => 74.3587,
                'rating' => 4.8,
                'bio' => 'Licensed electrician with 5+ years experience.',
                'is_available' => true,
            ]
        );

        $customer1 = User::updateOrCreate(
            ['email' => 'sara@demo.com'],
            [
                'name' => 'Sara Khan',
                'password' => Hash::make('password'),
                'role' => 'user',
                'address' => '123 Main Street, Lahore',
            ]
        );

        $customer2 = User::updateOrCreate(
            ['email' => 'hammad@demo.com'],
            [
                'name' => 'Hammad Mukhtar',
                'password' => Hash::make('password'),
                'role' => 'user',
                'address' => 'DHA Phase 5, Lahore',
            ]
        );

        $service = Service::updateOrCreate(
            ['worker_id' => $worker->id, 'title' => 'Electrical Repair'],
            [
                'category' => 'Electrical',
                'price' => 45,
                'rating' => 4.8,
                'description' => 'Home and office electrical repairs.',
            ]
        );

        $plumbing = Service::updateOrCreate(
            ['worker_id' => $worker->id, 'title' => 'Plumbing Fix'],
            [
                'category' => 'Plumbing',
                'price' => 30,
                'rating' => 4.6,
                'description' => 'Leak repairs and pipe installation.',
            ]
        );

        $pending = Booking::updateOrCreate(
            ['worker_id' => $worker->id, 'user_id' => $customer1->id, 'date' => now()->addDays(3)->toDateString()],
            [
                'service_id' => $service->id,
                'time' => '14:00:00',
                'customer_address' => '123 Main Street, Lahore',
                'customer_lat' => '31.5497',
                'customer_lng' => '74.3436',
                'customer_formatted_address' => '123 Main Street, Lahore, Pakistan',
                'status' => 'pending',
            ]
        );

        $accepted = Booking::updateOrCreate(
            ['worker_id' => $worker->id, 'user_id' => $customer2->id, 'date' => now()->addDay()->toDateString()],
            [
                'service_id' => $service->id,
                'time' => '10:00:00',
                'customer_address' => 'DHA Phase 5, Lahore',
                'customer_lat' => '31.4697',
                'customer_lng' => '74.4100',
                'customer_formatted_address' => 'DHA Phase 5, Lahore, Pakistan',
                'status' => 'accepted',
                'accepted_at' => now(),
            ]
        );

        $completed = Booking::updateOrCreate(
            ['worker_id' => $worker->id, 'user_id' => $customer1->id, 'date' => now()->subDays(5)->toDateString()],
            [
                'service_id' => $plumbing->id,
                'time' => '16:00:00',
                'customer_address' => 'Gulberg III, Lahore',
                'status' => 'completed',
                'completed_at' => now()->subDays(4),
                'rating' => 5,
                'review' => 'Great work, very professional!',
            ]
        );

        Earning::updateOrCreate(
            ['booking_id' => $completed->id],
            [
                'worker_id' => $worker->id,
                'amount' => 30,
                'status' => 'paid',
                'earned_date' => now()->subDays(4)->toDateString(),
            ]
        );

        $convId = implode('_', [min($worker->id, $customer1->id), max($worker->id, $customer1->id)]);

        Message::updateOrCreate(
            ['conversation_id' => $convId, 'sender_id' => $customer1->id, 'text' => 'ok see you soon'],
            [
                'receiver_id' => $worker->id,
                'is_read' => false,
            ]
        );

        Message::updateOrCreate(
            ['conversation_id' => $convId, 'sender_id' => $worker->id, 'text' => 'Sure, I will be there on time.'],
            [
                'receiver_id' => $customer1->id,
                'is_read' => true,
                'read_at' => now(),
            ]
        );

        WorkerActivity::create([
            'worker_id' => $worker->id,
            'text' => 'NEW BOOKING: Electrical Repair booking received.',
        ]);

        WorkerActivity::create([
            'worker_id' => $worker->id,
            'text' => 'ACCEPTED: Booking #' . $accepted->id . ' accepted.',
        ]);

        $worker->update([
            'total_jobs' => 1,
            'total_earnings' => 30,
        ]);
    }
}
