<style>
    @import url(https://fonts.googleapis.com/css?family=Montserrat);


    svg {
        display: block;
        font: 6.5em 'Montserrat';
        width: 960px;
        height: 140px;
        margin: 0 auto;
    }
    
    .text-copy {
        fill: none;
        stroke: white;
        stroke-dasharray: 6% 29%;
        stroke-width: 5px;
        stroke-dashoffset: 0%;
        animation: stroke-offset 5.5s infinite linear;
    }
    
    .text-copy:nth-child(1){
        stroke: #4D163D;
        animation-delay: -1;
    }
    
    .text-copy:nth-child(2){
        stroke: #840037;
        animation-delay: -2s;
    }
    
    .text-copy:nth-child(3){
        stroke: #BD0034;
        animation-delay: -3s;
    }
    
    .text-copy:nth-child(4){
        stroke: #BD0034;
        animation-delay: -4s;
    }
    
    .text-copy:nth-child(5){
        stroke: #FDB731;
        animation-delay: -5s;
    }
    
    @keyframes stroke-offset{
        100% {stroke-dashoffset: -35%;}
    }
    </style>

    <svg viewBox="0 0 960 200">
        <symbol id="s-text">
            <text text-anchor="middle" x="50%" y="80%">MO Workadmin</text>
        </symbol>
    
        <g class = "g-ants">
            <use xlink:href="#s-text" class="text-copy"></use>
            <use xlink:href="#s-text" class="text-copy"></use>
            <use xlink:href="#s-text" class="text-copy"></use>
            <use xlink:href="#s-text" class="text-copy"></use>
            <use xlink:href="#s-text" class="text-copy"></use>
        </g>
    </svg>