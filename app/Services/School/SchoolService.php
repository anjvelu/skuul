<?php

namespace App\Services\School;

use App\Models\School;
use Illuminate\Support\Str;
use App\Services\User\UserService;


class SchoolService
{
    public $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getAllSchools()
    {
       return School::all();
    }

    public function getSchoolById($id)
    {
        return School::find($id);
    }

    public function createSchool($records)
    {
        $school = School::create($records);
        session()->flash('success',  __('School created successfully'));
        
        return $school;
    }

    public function updateSchool($id, $records)
    {
        $school = $this->getSchoolById($id);
        $school->update($records);
        session()->flash('success',  __('School updated successfully'));

        return $school;
    }

    public function setSchool($id)
    {
        $school = $this->getSchoolById($id);

        if ($school->exists()) {
            $user = $this->userService->getUserById(auth()->user()->id);
            $user->school_id = $school->id;
            $user->save();
            session()->flash('success', __('School set successfully'));

            return true;
        }

        session()->flash('danger', __('School not found'));
        return false;
    }

    public function generateSchoolCode(){
        return Str::random(10);
    }
    
}