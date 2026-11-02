<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\AcademicCalendar;
use Carbon\Carbon;

class LectureWeekRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $date = Carbon::parse($value)->toDateString();

        $isLectureWeek = AcademicCalendar::where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->where('is_lecture_week', true)
            ->whereHas('semester', function ($query) {
                $query->where('is_active', true);
            })
            ->exists();

        if (!$isLectureWeek) {
            $fail('La fecha seleccionada no corresponde a una semana lectiva de clases.');
        }
    }
}
