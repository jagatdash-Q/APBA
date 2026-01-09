<div class="dots" id="loader"></div>

<style>
    .dots {
        width: 56px;
        height: 26.9px;
        background: radial-gradient(circle closest-side, #474bff 90%, #0000) 0% 50%,
            radial-gradient(circle closest-side, #474bff 90%, #0000) 50% 50%,
            radial-gradient(circle closest-side, #474bff 90%, #0000) 100% 50%;
        background-size: calc(100%/3) 13.4px;
        background-repeat: no-repeat;
        animation: dots-7ar3yq 1s infinite linear;
    }

    .disable-loader{
        pointer-events: none;
        background: radial-gradient(#000, rgb(41, 41, 41));
        opacity: 0.7;
    }

    #loader {
        display: none;
        position: fixed;
        z-index: 9999;
        padding: 0;
        margin: 0;
        width: 5%;
        top: 50%;
        left:50%;
    }

    @keyframes dots-7ar3yq {
        20% {
            background-position: 0% 0%, 50% 50%, 100% 50%;
        }

        40% {
            background-position: 0% 100%, 50% 0%, 100% 50%;
        }

        60% {
            background-position: 0% 50%, 50% 100%, 100% 0%;
        }

        80% {
            background-position: 0% 50%, 50% 50%, 100% 100%;
        }
    }
</style>
