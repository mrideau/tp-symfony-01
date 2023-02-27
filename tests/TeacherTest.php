<?php

namespace App\Tests;

use App\Entity\Classroom;
use App\Entity\Teacher;
use PHPUnit\Framework\TestCase;

class TeacherTest extends TestCase
{
    public function testName() {
        $teacher = new Teacher();
        $teacher->setFirstname('firstname');
        $teacher->setLastname('lastname');

        $expectedFullname = $teacher->getLastname() . ' ' . $teacher->getFirstname();

        $this->assertEquals('firstname', $teacher->getFirstname());
        $this->assertEquals('lastname', $teacher->getLastname());
        $this->assertEquals($expectedFullname, $teacher->getFullname());
    }

    public function testAdding3Classroom() {
        $teacher = new Teacher();

        $this->assertTrue($teacher->getClassrooms()->count() === 0);

        $teacher->addClassroom(new Classroom());

        $this->assertTrue($teacher->getClassrooms()->count() === 1);

        $teacher->addClassroom(new Classroom());
        $teacher->addClassroom(new Classroom());


        $this->assertTrue($teacher->getClassrooms()->count() === 3);
    }
}
