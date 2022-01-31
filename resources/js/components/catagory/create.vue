<template>
    <div>
        <div class="row col-xl-3 col-lg-3 col-md-3">
            <router-link to="/catagory" class="btn btn-primary btn-sm">All Catagory</router-link>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                <div class="card-body p-0">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4 btn-sm">Add Catagory</h1>
                        </div>
                        <form class="user" @submit.prevent="catagoryInsert" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                    <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Catagory Name" v-model="form.catagory_name">
                                    <small class="text-danger" v-if="errors.catagory_name">{{ errors.catagory_name[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
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
                catagory_name: null,
            },
            errors:{},
        }
    },
    methods: {
        catagoryInsert(){
            axios.post('/api/catagory',this.form)
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