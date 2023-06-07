<template>
    <div>
        <div v-if="componentFound == false" class="parent-background">
            Nothing uploaded yet
        </div>
        <div v-else-if="componentFound == null" class="loading-spinner-view parent-background">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div v-else-if="componentFound == true" class="parent-background">
            <div class="row home-row">
                <div class="col-md-3 d-none d-md-block">
                    <div class="nav-sidebar">
                        <div v-for="(option, index) in options" :key="index" class="nav-item">
                            <router-link class="nav-link text-capitalize no-underline" :to="option.table_name_starts_with">{{ option.nav_headline }}</router-link>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="home-card-container">
                        <a v-for="(option, index) in options" :key="index" class="card" :href="option.table_name_starts_with" target="_blank">
                            <div class="card-body">
                                <h5 class="card-title">{{ option.headline }}</h5>
                                <div class="child-list">
                                    <span v-for="(child, childIndex) in option.lists_of_data" :key="childIndex" class="child-item">
                                    {{ child.name }} ({{child.amount}}){{ childIndex < 9 ? ', ' : '' }}
                                    </span>.. See more
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            options: [],
            componentFound: null,
        };
    },

    created(){
        this.getAllPages();
    },

    methods:{
        getAllPages(){
            axios.get('/api/get-all-data-from-custom-all-tables-for-user')
            .then(response =>{
                console.log(response);
                if(response.data.success == true){
                    this.componentFound = true;
                    this.options = [];
                    response.data.allData.forEach(item => {
                        this.options.push(item);
                    });
                }
                else{
                    this.componentFound = false;
                }
            })
            .catch(error =>{
                toast.error(error.response.data.message);
            })
        },
    }
};
</script>