<template>
    <div>
        <div class="row col-xl-3 col-lg-3 col-md-3">
            <router-link to="/catagory" class="btn btn-primary btn-sm">Add Catagory</router-link>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-112 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                <div class="card-body p-0">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Catagory Update</h1>
                        </div>
                        <form class="user" @submit.prevent="catagoryUpdate" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                    <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Catagory Name" v-model="form.catagory_name">
                                    <small class="text-danger" v-if="errors.catagory_name">{{ errors.catagory_name[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                            </div>
                            <hr>
                        </form>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
export default {
    created(){
        if(!User.loggedIn()){
            this.$router.push({ name: '/'})
        }   
    },
    data(){
        return {
            form:{
                catagory_name: '',
            },
            errors:{},
        }
    },
    created() {
        let id = this.$route.params.id
        axios.get('/api/catagory/'+id)
        .then(({data}) => (this.form = data))
        .catch(console.log('error'))
    },
    methods: {
        catagoryUpdate(){
            let id = this.$route.params.id
            axios.patch('/api/catagory/'+id,this.form)
            .then(() => {
                this.$router.push({ name: 'catagory'})
                Notification.success()
            })
            .catch(error => this.errors = error.response.data.errors)
            .catch(
                Toast.fire({
                icon: 'warning',
                title: 'Something Went Wrong!'
                })
            )
        },
    },
}
</script>

<style type="text/css">

</style>