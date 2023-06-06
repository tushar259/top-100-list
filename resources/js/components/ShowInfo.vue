<template>
    <div>
        <button @click="getLocation">Get Current Location</button>
        <p v-if="location">Location: {{ location.name }}, Latitude: {{ location.lat }}, Longitude: {{ location.lng }}</p>
    </div>
</template>

<script>
export default {
    name: 'App',
    data(){
        return {
            location: null,
        };
    },

    methods: {
        getLocation(){
            if (navigator.geolocation){
                navigator.geolocation.getCurrentPosition(
                    position => {
                      const { latitude, longitude } = position.coords;
                      this.reverseGeocode(latitude, longitude);
                    },
                    error => {
                      console.error('Error getting current location:', error);
                    }
                );
            } 
            else{
              console.error('Geolocation is not supported by this browser.');
            }
        },

        reverseGeocode(latitude, longitude){
            const formData = new FormData();
            formData.append("latitude", latitude);
            formData.append("longitude", longitude);
            axios.post("/api/geocode", formData)
            .then(response =>{
                console.log(response);
            })
            .catch(error =>{
                console.log(error);
            });

        }
    }

}
</script>

<style lang="scss">
</style>
