<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Judite\Models\Course;
use App\Judite\Models\Student;
use App\Judite\Models\Exchange;
use App\Judite\Models\Enrollment;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StudentTest extends TestCase
{
    use DatabaseTransactions;

    public function testStudentEnrollsInCourse()
    {
        // Prepare
        $student = factory(Student::class)->create();
        $course = factory(Course::class)->create();

        // Execute
        $actualReturn = $student->enroll($course);

        // Assert
        $this->assertEquals(Enrollment::class, get_class($actualReturn));
        $this->assertEquals(1, Enrollment::count());
        $enrollment = Enrollment::first();
        $this->assertEquals($student->id, $enrollment->student_id);
        $this->assertEquals($course->id, $enrollment->course_id);
    }

    public function testStudentIsEnrolledInCourse()
    {
        // Prepare
        $student = factory(Student::class)->create();
        $course = factory(Course::class)->create();
        factory(Enrollment::class)->create([
            'student_id' => $student->id,
            'course_id' => $course->id,
        ]);

        // Execute
        $actualReturn = $student->isEnrolledInCourse($course);

        // Assert
        $this->assertTrue($actualReturn);
    }

    public function testGetExchangesRequestedByStudent()
    {
        // Prepare
        $student = factory(Student::class)->create();
        $enrollments = factory(Enrollment::class, 2)->create(['student_id' => $student->id]);
        $enrollments->each(function ($enrollment) {
            factory(Exchange::class)->create(['from_enrollment_id' => $enrollment->id]);
            factory(Exchange::class)->create(['to_enrollment_id' => $enrollment->id]);
        });

        // Execute
        $actualReturn = $student->requestedExchanges();

        // Assert
        $expectedExchanges = Exchange::whereIn('from_enrollment_id', $student->enrollments->pluck('id'))->get();
        $this->assertEquals($expectedExchanges->pluck('id'), $actualReturn->pluck('id'));
    }

    public function testGetWaitingConfirmationExchangesFromStudent()
    {
        // Prepare
        $student = factory(Student::class)->create();
        $enrollments = factory(Enrollment::class, 2)->create(['student_id' => $student->id]);
        $enrollments->each(function ($enrollment) {
            factory(Exchange::class)->create(['from_enrollment_id' => $enrollment->id]);
            factory(Exchange::class)->create(['to_enrollment_id' => $enrollment->id]);
        });

        // Execute
        $actualReturn = $student->proposedExchanges();

        // Assert
        $expectedExchanges = Exchange::whereIn('to_enrollment_id', $student->enrollments->pluck('id'))->get();
        $this->assertEquals($expectedExchanges->pluck('id'), $actualReturn->pluck('id'));
    }
}