<?php
use App\Models\User;
use App\Models\DutyMember;

$user = User::where('name', 'like', '%Radiansyah%')->first();
$dm = DutyMember::with('attendances')->where('user_id', $user->id)->first();
print_r($dm->attendances->toArray());
