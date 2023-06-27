<template>
    <div class="flex">
        <div class="w-1/3 p-4">
            <input type="text" v-model="latitude" placeholder="Широта" class="w-full px-2 py-1 border border-gray-300 rounded" />
            <div v-if="latitudeError" class="text-red-500 mt-1">{{ latitudeError }}</div>
            <input type="text" v-model="longitude" placeholder="Долгота" class="w-full mt-2 px-2 py-1 border border-gray-300 rounded" />
            <div v-if="longitudeError" class="text-red-500 mt-1">{{ longitudeError }}</div>
            <button @click.prevent="sendCoordinates" class="w-full mt-2 py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700">Отправить координаты</button>
        </div>
        <div class="w-2/3 p-4">
            <GoogleMap style="width: 100%; height: 500px" :center="center" :zoom="15">
                <Marker v-for="marker in markers" :key="marker.id" :options="marker.options" />
            </GoogleMap>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { defineComponent, ref, onMounted } from "vue";
import { GoogleMap, Marker } from "vue3-google-map";

export default defineComponent({
    components: { GoogleMap, Marker },
    setup() {
        const center = ref({ lat: 40.689247, lng: -74.044502 });
        const latitude = ref("");
        const longitude = ref("");
        const markers = ref([]);
        const latitudeError = ref("");
        const longitudeError = ref("");

        const sendCoordinates = () => {
            // Очищаем предыдущие ошибки
            latitudeError.value = "";
            longitudeError.value = "";



            const url = 'api/storeLocation';
            const data = {
                latitude: latitude.value,
                longitude: longitude.value
            };

            axios.post(url, data)
                .then(response => {
                    console.log(response.data);
                    // Обработка успешного ответа
                })
                .catch(error => {
                    if (error.response && error.response.data && error.response.data.errors) {
                        const serverErrors = error.response.data.errors;
                        if (serverErrors.latitude && serverErrors.latitude.length > 0) {
                            latitudeError.value = serverErrors.latitude[0];
                        }
                        if (serverErrors.longitude && serverErrors.longitude.length > 0) {
                            longitudeError.value = serverErrors.longitude[0];
                        }
                    } else {
                        console.error(error);
                    }
                    // Обработка ошибки
                });
        };

        const sendGetRequest = () => {
            const url = 'api/getLocation';

            axios.get(url)
                .then(response => {
                    const locations = response.data.data;
                    markers.value = locations.map(location => {
                        return {
                            id: location.id,
                            options: {
                                position: { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) }
                            }
                        };
                    });
                    // Обновление массива markers данными из GET-запроса
                })
                .catch(error => {
                    console.error(error);
                    // Обработка ошибки
                });
        };

        const sendPostRequest = () => {
            const url = 'api/deleteLocation';
            axios.post(url)
                .then(response => {
                    console.log(response.data);
                    // Обработка успешного ответа
                })
                .catch(error => {
                    console.error(error);
                });
        };

        const markerOptions = (marker) => {
            return { position: marker.position };
        };

        onMounted(() => {
            setInterval(sendGetRequest, 2000);
        });

        onMounted(() => {
            setInterval(sendPostRequest, 60000);
        });


        return { center, latitude, longitude, markers, sendCoordinates, markerOptions, latitudeError, longitudeError };
    },
});
</script>
