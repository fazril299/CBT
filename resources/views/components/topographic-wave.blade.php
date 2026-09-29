@props(['type' => 'welcome'])

@php
    // Height & wave paths depending on screen type
    $isWelcome = $type === 'welcome';
    $containerHeight = $isWelcome ? 'h-[58vh] min-h-[380px]' : 'h-[34vh] min-h-[220px]';
@endphp

<div class="relative w-full {{ $containerHeight }} overflow-hidden bg-gradient-to-br from-[#FF7A7A] via-[#FF6E6E] to-[#FA5F5F] select-none">
    <!-- Topographic Contour Lines SVG -->
    <svg class="absolute inset-0 w-full h-full object-cover pointer-events-none opacity-40 mix-blend-screen" 
         viewBox="0 0 400 480" 
         preserveAspectRatio="none" 
         fill="none" 
         xmlns="http://www.w3.org/2000/svg">
        
        <!-- Center-Right Topo Loop Cluster -->
        <ellipse cx="270" cy="180" rx="30" ry="24" stroke="#FFFFFF" stroke-width="1.8" />
        <ellipse cx="270" cy="180" rx="58" ry="46" stroke="#FFFFFF" stroke-width="1.8" />
        <ellipse cx="265" cy="178" rx="90" ry="72" stroke="#FFFFFF" stroke-width="1.8" />
        <ellipse cx="260" cy="175" rx="125" ry="98" stroke="#FFFFFF" stroke-width="1.8" />
        <path d="M 90,140 C 130,70 230,80 320,110 C 390,135 410,210 370,270 C 330,330 200,320 150,260 C 110,210 60,190 90,140 Z" stroke="#FFFFFF" stroke-width="1.8" />

        <!-- Top-Left Topo Cluster -->
        <ellipse cx="90" cy="70" rx="22" ry="18" stroke="#FFFFFF" stroke-width="1.8" />
        <ellipse cx="92" cy="72" rx="48" ry="38" stroke="#FFFFFF" stroke-width="1.8" />
        <ellipse cx="95" cy="75" rx="80" ry="65" stroke="#FFFFFF" stroke-width="1.8" />
        <ellipse cx="100" cy="80" rx="120" ry="95" stroke="#FFFFFF" stroke-width="1.8" />

        <!-- Bottom-Center Organic Loop -->
        <ellipse cx="180" cy="310" rx="35" ry="26" stroke="#FFFFFF" stroke-width="1.8" />
        <ellipse cx="185" cy="308" rx="65" ry="50" stroke="#FFFFFF" stroke-width="1.8" />
        <ellipse cx="190" cy="305" rx="105" ry="80" stroke="#FFFFFF" stroke-width="1.8" />

        <!-- Outer flowing organic contours -->
        <path d="M-30,40 C 60,20 180,-10 260,20 C 350,55 420,140 430,230 C 440,320 370,390 280,420 C 190,450 70,410 10,350 C -40,300 -60,190 -30,40 Z" stroke="#FFFFFF" stroke-width="1.6" />
        <path d="M-60,10 C 40,-20 190,-30 290,5 C 390,45 460,160 460,270 C 460,370 380,450 260,470 C 140,490 20,440 -40,370 Z" stroke="#FFFFFF" stroke-width="1.6" />
        <path d="M 20,480 C 100,430 210,440 290,410 C 370,380 430,310 440,240" stroke="#FFFFFF" stroke-width="1.6" />
        
        <!-- Small organic micro-islands -->
        <circle cx="210" cy="140" r="4" fill="#FFFFFF" fill-opacity="0.6" />
        <ellipse cx="320" cy="240" rx="8" ry="5" stroke="#FFFFFF" stroke-width="1.5" />
        <ellipse cx="70" cy="260" rx="14" ry="10" stroke="#FFFFFF" stroke-width="1.5" />
        <circle cx="140" cy="210" r="3" fill="#FFFFFF" fill-opacity="0.6" />
    </svg>


    <!-- Organic Wave Divider to White Card Bottom -->
    <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-none pointer-events-none z-10">
        @if($isWelcome)
            <!-- S-Curve for Welcome Screen (starts mid-left, sweeps up then cascades right) -->
            <svg class="relative block w-full h-16 sm:h-20" viewBox="0 0 375 75" preserveAspectRatio="none">
                <path d="M 0,25 C 75,5 140,5 200,32 C 265,60 320,68 375,55 L 375,75 L 0,75 Z" fill="#FFFFFF"></path>
            </svg>
        @else
            <!-- Organic Curve for Sign In / Sign Up Screen -->
            <svg class="relative block w-full h-14 sm:h-16" viewBox="0 0 375 60" preserveAspectRatio="none">
                <path d="M 0,15 C 90,8 180,35 270,42 C 320,46 350,30 375,20 L 375,60 L 0,60 Z" fill="#FFFFFF"></path>
            </svg>
        @endif
    </div>
</div>
