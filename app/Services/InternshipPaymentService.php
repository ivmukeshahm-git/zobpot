<?php

namespace App\Services;

use App\Models\Internship;
use Carbon\Carbon;

class InternshipPaymentService
{
    /**
     * Calculate internship registration payment with late fee and GST.
     *
     * Late fee applies from last_registration_date onwards (inclusive).
     *
     * @param  Internship|object|array  $internship
     * @param  Carbon|string|null  $asOfDate  Optional date for calculation (defaults to today)
     * @return array{
     *     registration_fee: float,
     *     late_registration_fee: float,
     *     configured_late_registration_fee: float,
     *     last_registration_date: ?string,
     *     subtotal: float,
     *     gst_percentage: float,
     *     gst_amount: float,
     *     total_amount: float,
     *     is_late_registration: bool
     * }
     */
    
    public function calculatePayment($internship, $asOfDate = null): array
    {
        if ($internship instanceof Internship) {
            $registrationFee = (float) ($internship->registration_fees ?? 0);
            $configuredLateFee = (float) ($internship->late_registration_fee ?? 0);
            $gstPercentage = (float) ($internship->gst_percentage ?? 0);
            $lastRegistrationDate = $internship->last_registration_date;
        } elseif (is_array($internship)) {
            $registrationFee = (float) ($internship['registration_fees'] ?? $internship['registration_fee'] ?? 0);
            $configuredLateFee = (float) ($internship['late_registration_fee'] ?? 0);
            $gstPercentage = (float) ($internship['gst_percentage'] ?? 0);
            $lastRegistrationDate = $internship['last_registration_date'] ?? null;
        } else {
            $registrationFee = (float) ($internship->registration_fees ?? $internship->registration_fee ?? 0);
            $configuredLateFee = (float) ($internship->late_registration_fee ?? 0);
            $gstPercentage = (float) ($internship->gst_percentage ?? 0);
            $lastRegistrationDate = $internship->last_registration_date ?? null;
        }

        $today = $asOfDate
            ? Carbon::parse($asOfDate)->startOfDay()
            : Carbon::today();

        $isLateRegistration = false;
        $lastRegistrationDateStr = null;

        if (!empty($lastRegistrationDate)) {
            try {
                $deadline = $lastRegistrationDate instanceof Carbon
                    ? $lastRegistrationDate->copy()->startOfDay()
                    : Carbon::parse($lastRegistrationDate)->startOfDay();
                $lastRegistrationDateStr = $deadline->toDateString();
                // From last registration date onwards, late fee applies
                $isLateRegistration = $today->gte($deadline);
            } catch (\Throwable $e) {
                $isLateRegistration = false;
            }
        }

        $lateRegistrationFee = $isLateRegistration ? max(0, $configuredLateFee) : 0.0;
        $subtotal = round($registrationFee + $lateRegistrationFee, 2);
        $gstAmount = round(($subtotal * $gstPercentage) / 100, 2);
        $totalAmount = round($subtotal + $gstAmount, 2);

        return [
            'registration_fee' => round($registrationFee, 2),
            'late_registration_fee' => round($lateRegistrationFee, 2),
            'configured_late_registration_fee' => round($configuredLateFee, 2),
            'last_registration_date' => $lastRegistrationDateStr,
            'subtotal' => $subtotal,
            'gst_percentage' => round($gstPercentage, 2),
            'gst_amount' => $gstAmount,
            'total_amount' => $totalAmount,
            'is_late_registration' => $isLateRegistration,
        ];
    }
}
