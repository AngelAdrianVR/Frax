<template>
    <div>
        <header>

        </header>
        <main class="overflow-auto h-20 ">
            <section class="grid grid-cols-12 gap-0 mr-2">
                <button type="button" v-for="(item, index) in icons" :key="index"
                    class="border border-grayElement flex items-center justify-center py-2 text-sm text-gray2 hover:text-gray1">
                    <i :class="item"></i>
                </button>
            </section>
        </main>
    </div>
</template>
<script>
export default {
    data() {
        return {
            icons: [
                'fa-solid fa-a',
                'fa-regular fa-address-book',
                'fa-regular fa-address-card',
                'fa-solid fa-award',
                'fa-brands fa-accessible-icon',
                'fa-solid fa-atom',
                'fa-solid fa-at',
                'fa-solid fa-asterisk',
                'fa-solid fa-apple-whole',
                'fa-solid fa-b',
                'fa-solid fa-bell',
                'fa-solid fa-bolt',
                'fa-solid fa-book',
                'fa-solid fa-bicycle',
                'fa-solid fa-brush',
                'fa-solid fa-bath',
                'fa-solid fa-bug',
                'fa-solid fa-bag-shopping',
                'fa-solid fa-brain',
                'fa-solid fa-bullseye',
                'fa-solid fa-baby',
                'fa-solid fa-burger',
                'fa-solid fa-bullhorn',
                'fa-solid fa-broom',
                'fa-solid fa-box',
                'fa-solid fa-bowling-ball',
                'fa-solid fa-bone',
                'fa-solid fa-bed',
                'fa-solid fa-battery-full',
                'fa-solid fa-basketball',
                'fa-solid fa-baseball',
                'fa-solid fa-ban',
                'fa-solid fa-ban-smoking',
                'fa-solid fa-check',
                'fa-solid fa-camera-retro',
                'fa-solid fa-cloud',
                'fa-solid fa-car',
                'fa-solid fa-comments',
                'fa-solid fa-calendar-days',
                'fa-solid fa-crown',
                'fa-solid fa-coins',
                'fa-solid fa-crosshairs',
                'fa-solid fa-cookie-bite',
                'fa-solid fa-crow',
                'fa-solid fa-dumbbell',
                'fa-solid fa-dog',
                'fa-solid fa-eye',
                'fa-solid fa-fish',
                'fa-solid fa-flag',
                'fa-solid fa-futbol',
                'fa-solid fa-fire-extinguisher',
                'fa-solid fa-gift',
                'fa-solid fa-gear',
                'fa-solid fa-glasses',
                'fa-solid fa-guitar',
                'fa-solid fa-house',
                'fa-solid fa-hand',
                'fa-solid fa-heart',
                'fa-solid fa-hammer',
                'fa-solid fa-headset',
                'fa-solid fa-image',
                'fa-solid fa-infinity',
                'fa-solid fa-ice-cream',
                'fa-solid fa-key',
                'fa-solid fa-location-dot',
                'fa-solid fa-music',
                'fa-solid fa-mosquito',
                'fa-solid fa-microphone',
                'fa-solid fa-mobile-screen',
                'fa-solid fa-map',
                'fa-solid fa-pen',
                'fa-solid fa-phone',
                'fa-solid fa-person',
                'fa-solid fa-plug',
                'fa-solid fa-puzzle-piece',
                'fa-solid fa-play',
                'fa-solid fa-pause',
                'fa-solid fa-water',
                'fa-solid fa-person-swimming',
                'fa-solid fa-dollar-sign',
                'fa-solid fa-fan',
            ],
        }
    },
}
</script>