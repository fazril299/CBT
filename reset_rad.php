<?php
use App\Models\Attendance;

Attendance::where('id', 15)->delete();
echo "Attendance record deleted. Status reset.\n";
