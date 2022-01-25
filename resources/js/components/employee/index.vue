<template>
    <div>
    <div class="row">
        <router-link to="/store-employee" class="btn btn-primary">Add employee</router-link>
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-112 col-lg-12 col-md-12">
            <div class="card shadow-sm my-5">
            <div class="card-body p-0">
                <div class="row">
                <div class="col-lg-12">
                    <div class="login-form">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">ALL Employee</h1>
                    </div>
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
                name: null,
                email: null,
                address: null,
                salary: null,
                joining_date: null,
                nid: null,
                phone: null,
                photo: null,
            },
            errors:{

            },
        }
    },
    methods: {
        employeeInsert(){
            f
        },
    },
}
</script>

<style type="text/css">

</style>