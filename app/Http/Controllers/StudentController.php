<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Container\Container;
use Illuminate\Http\Request;

class StudentController
{
    public function index()
    {
        $app = Container::getInstance();
        $student = Student::all();
        $factory = $app->make('view');
        // 调用视图传输数据
        return $factory->make('students.index')->with('data', $student);
    }
}