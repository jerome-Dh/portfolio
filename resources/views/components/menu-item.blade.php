@php
    $width = (strlen($name) >= 10) ? 210 : 170;
    $w_path = $width - 40;
    $x_trans = ($width == 210) ? 45 : 50;
@endphp

<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
     width="{!! $width !!}" height="90"
     viewBox="0 0 {!! $width !!} 90">
    <defs>
        <style>
            .cls-20 {
                fill: @if($active) #f7df1e @else #fff @endif;
                font-size: 16px;
            }
            .cls-20:hover {
                fill: #f7df1e;
            }
            .cls-21 {
                stroke: #eee;
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
        <text class="cls-20" transform="translate({!! $x_trans !!} 38)">
            <tspan x="0" y="0">{{ $name }}</tspan>
        </text>
        <path class="cls-21" d="M0,0 l{!! $w_path !!},0 l30,40 l-{!! $w_path !!},0 z" transform="translate(0 10)" />

        @if($active)
            <path class="cls-22 hover-item" d="M0,0 l30,40 l{!! $w_path !!},0 l0,5 l-{!! ($w_path + 30) !!},0z" transform="translate(0 10)"/>
            <rect class="cls-22 hover-item" x="{!! (($width - 10) / 2) - 5 !!}" y="45" width="10" height="10" transform="translate(0 10)"/>
        @endif
    </g>

</svg>
