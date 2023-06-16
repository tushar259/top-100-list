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
            <!-- <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center mb-4">{{ headline }}</h2>
                        <p class="text-center">Updated: {{ updatedAt }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li v-for="(child, index) in allChilds" :key="index" class="list-group-item">
                                    <div class="row">
                                        <div class="col-2">
                                            <p class="list-serial">{{ index + 1 }}</p>
                                        </div>
                                        <div class="col-6">
                                            <h4 class="list-title">{{ child.name }}</h4>
                                        </div>
                                        <div class="col-4">
                                            <p class="list-amount">{{ child.amount_bigint }}</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="top-list-container">
                <div class="top-list-header">{{ headline }}</div>
                <div class="top-list-updated">Last updated: {{ updatedAt }}</div>
                <div class="top-list-items" v-for="(child, index) in allChilds" :key="index">
                    <div class="top-list-item">
                        <div class="top-list-serial">{{ index + 1 }}</div>
                        <div class="top-list-name text-capitalize">{{ child.name }}</div>
                        <div class="top-list-amount">{{ child.amount_bigdouble }}</div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {

    data(){
        return{
            routeName: this.$route.params.allComponent,
            componentFound: null,
            headline: '',
            navHeadline: '',
            updatedAt: '',
            allChilds: []
        };
    },

    created(){
        this.componentFound = null;
        // console.log(this.$route);
        this.getAllData();
    },

    mounted() {
        const metaTag = document.getElementById('pageDescriptionMeta');
        if (metaTag) {
            metaTag.setAttribute('name', 'description');
            metaTag.setAttribute('content', 'Your meta description');
        }
    },

    methods: {
        getAllData(){
            const formData = new FormData();
            this.routeName = this.routeName.replace(/:/g, '');
            formData.append("routeName", this.routeName);
            axios.post("/api/get-current-component-with", formData)
            .then(response =>{
                // console.log(response);
                if(response.data.success == true){
                    this.componentFound = true;
                    this.headline = response.data.allData.headline;
                    this.navHeadline = response.data.allData.nav_headline;
                    this.updatedAt = response.data.allData.updated_at;
                    this.allChilds = [];
                    response.data.allData.all_childs.forEach(item => {
                        this.allChilds.push(item);
                    });
                    document.title = "My website - "+this.headline;
                }
                else{
                    this.componentFound = false;
                }
                
            })
            .catch(error =>{
                // console.log(error);
            });
        },

        
    }
};
</script>