<script setup lang="ts">
import {CustomMarker, GoogleMap} from "vue3-google-map";
import {onMounted, onUnmounted} from "vue";
import {loadRecaptcha, removeRecaptcha} from "@/utils/recaptcha";

const center = { lat: 48.4494, lng: 25.919 }

const mapOptions = {
    disableDefaultUI: true,
    zoomControl: true,
}

declare global {
    interface Window {
        grecaptcha: any;
        recaptchaSiteKey: string;
        mapApiKey: string;
    }
}

const mapKey = window.mapApiKey;

onMounted(async () => {
    await loadRecaptcha(window.recaptchaSiteKey);
});

onUnmounted(() => {
    removeRecaptcha();
});
</script>

<template>
    <section class="section">
        <h2 class="heading-line">Карта</h2>

        <GoogleMap
            :api-key="mapKey"
            map-id="DEMO_MAP_ID"
            style="width: 100%; height: 450px; border-radius: 12px; overflow: hidden;"
            :center="center"
            :zoom="15"
            :options="mapOptions"
        >
            <CustomMarker :options="{ position: center }">
                <div class="map-marker-wrapper">
                    <div class="map-marker">
                        <div class="marker-content">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2ZM12 11.5C10.62 11.5 9.5 10.38 9.5 9C9.5 7.62 10.62 6.5 12 6.5C13.38 6.5 14.5 7.62 14.5 9C14.5 10.38 13.38 11.5 12 11.5Z" fill="currentColor"/>
                            </svg>
                        </div>
                        <div class="marker-pulse"></div>
                    </div>
                </div>
            </CustomMarker>
        </GoogleMap>
    </section>
</template>

<style scoped lang="scss">
.map-marker-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.map-marker {
    position: relative;
    width: 40px;
    height: 40px;
    color: $color-accent;
    cursor: pointer;

    .marker-content {
        position: relative;
        z-index: 2;
        width: 100%;
        height: 100%;
        filter: drop-shadow(0 4px 4px rgba(0, 0, 0, 0.4));
    }

    .marker-pulse {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 12px;
        height: 12px;
        background-color: currentColor;
        border-radius: 50%;
        z-index: 1;
        opacity: 0.6;
        animation: marker-pulse 2s infinite ease-out;
    }
}

@keyframes marker-pulse {
    0% {
        transform: translateX(-50%) scale(1);
        opacity: 0.8;
    }
    100% {
        transform: translateX(-50%) scale(4);
        opacity: 0;
    }
}
</style>
