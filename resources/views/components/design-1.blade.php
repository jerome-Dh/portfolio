<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:slink="http://www.w3.org/2000/svg"
     width="180"
     height="100"
     viewBox="0 0 180 100">
    <defs>
        <style>
            .rect {
                fill: #f00;
            }
            .line {
                stroke: #fff;
                stroke-width: 1px;
            }
            .line:hover {
                stroke: powderblue;
            }
            .text {
                fill: #fff;
                font-size: 22px;
                font-weight: bold;
            }
            .hov:hover {
                fill: #faa05a;
            }
        </style>
    </defs>

    <g>
        <path d="M30,5 L30,95 M5,50 L110,50 M50,10 L50,90 M50,10 L100,10 M50,50 L110,50 M50,90 L100,90z" class="line"/>
    </g>
    <g>
        <text class="text" transform="translate(115 19)">
            <tspan class="hov" x="0" y="0">{!! date('Y') !!}</tspan>
            <tspan class="hov" x="0" y="37">&#171;---&#187;</tspan>
            <tspan class="hov" x="0" y="74">2014</tspan>
        </text>

    </g>
</svg>
