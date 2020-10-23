@php
    $width = 210;
    $w_path = 180;
    $x_trans = 10;
@endphp

<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
     width="{!! $width !!}" height="90"
     viewBox="0 0 {!! $width !!} 90">
    <defs>
        <style>
            .cls-25 {
                fill: #4adde2;
                font-size: 1.5rem;
            }
            .cls-26 {
                stroke: #4adde2;
                fill: none;
            }
            .cls-22 {
                fill: #4adde2;
                stroke: #4adde2;
            }
            .hover-item:hover {
                fill: #b2f8fa;
            }
        </style>
    </defs>

    <g>
        <text class="cls-25" transform="translate({!! $x_trans !!} 38)">
            <tspan x="0" y="0">{{ $name }}</tspan>
        </text>
        <path class="cls-26" d="M0,0 l{!! $w_path !!},0 l30,40 l-{!! ($w_path+30) !!},0 z" transform="translate(0 5)" />
    </g>

</svg>
