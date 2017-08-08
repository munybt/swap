<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Judite\Models\Shift;
use App\Judite\Models\Course;
use App\Judite\Models\Student;
use App\Judite\Models\Enrollment;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EnrollmentTest extends TestCase
{
    use DatabaseTransactions;

    public function testEnrollmentsExchange()
    {
        // Prepare
        $course = factory(Course::class)->create();
        $fromEnrollment = factory(Enrollment::class)->create(['course_id' => $course->id]);
        $toEnrollment = factory(Enrollment::class)->create(['course_id' => $course->id]);
        $fromShiftId = $fromEnrollment->shift_id;
        $toShiftId = $toEnrollment->shift_id;

        // Execute
        $actualReturn = $fromEnrollment->exchange($toEnrollment);

        // Assert
        $this->assertSame($actualReturn, $fromEnrollment);
        $actualFromEnrollment = Enrollment::find($fromEnrollment->id);
        $actualToEnrollment = Enrollment::find($toEnrollment->id);
        $this->assertEquals($fromShiftId, $actualToEnrollment->shift_id);
        $this->assertEquals($toShiftId, $actualFromEnrollment->shift_id);
    }

    public function testOrderByCourse()
    {
        // Prepare
        $courses = factory(Course::class, 10)->create();
        $courses->each(function ($course) {
            $shift = factory(Shift::class)->make(['course_id' => $course->id]);
            factory(Enrollment::class)->create([
                'course_id' => $course->id,
                'shift_id' => $shift->id,
            ]);
        });

        // Execute
        $actualReturn = Enrollment::orderByCourse()->get();

        // Assert
        $expectedOrder = Course::orderBy('year', 'asc')
                                ->orderBy('semester', 'asc')
                                ->orderBy('name', 'asc')
                                ->get();

        $this->assertEquals($expectedOrder->pluck('id'), $actualReturn->pluck('course.id'));
    }

    public function testOrderByStudent()
    {
        // Prepare
        $course = factory(Course::class)->create();
        factory(Enrollment::class, 20)->create(['course_id' => $course->id]);

        // Execute
        $actualReturn = Enrollment::orderByStudent()->get();

        // Assert
        $expectedOrder = Student::orderBy('student_number')->get();

        $this->assertEquals($expectedOrder->pluck('id'), $actualReturn->pluck('student.id'));
    }

    /**
     * @expectedException App\Exceptions\UserIsAlreadyEnrolledInCourseException
     */
    public function testThrowsExceptionWhenStudentIsAlreadyEnrolledInCourse()
    {
        // Prepare
        $student = factory(Student::class)->create();
        $course = factory(Course::class)->create();
        factory(Enrollment::class)->create([
            'student_id' => $student->id,
            'course_id' => $course->id,
        ]);

        // Execute
        $student->enroll($course);
    }
}
