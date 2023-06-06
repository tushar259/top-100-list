<template>
    <div>
        <div v-if="componentFound == false" class="parent-background">
            Page not found
        </div>
        <div v-else-if="componentFound == null" class="loading-spinner-view parent-background">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div v-else-if="componentFound == true" class="parent-background">
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            routeName: this.$route.params.allComponent,
            componentFound: null,
        };
    },

    created(){
        this.getAllData();
    },

    methods: {
        getAllData(){
            const formData = new FormData();
            this.routeName = this.routeName.replace(/:/g, '');
            formData.append("routeName", this.routeName);
            axios.post("/api/get-current-component-with", formData)
            .then(response =>{
                console.log(response);
            })
            .catch(error =>{
                // console.log(error);
            });
        }
    }
};
</script>