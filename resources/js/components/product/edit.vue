<template>
    <div>
        <div class="row col-xl-3 col-lg-3 col-md-3">
            <router-link to="/product" class="btn btn-primary btn-sm">All Product</router-link>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-112 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                <div class="card-body p-0">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Product Update</h1>
                        </div>
                        <form class="user" @submit.prevent="productUpdate" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                    <label for="exampleFormControlSelect1"><b>Product Name</b></label>
                                    <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Product Name" v-model="form.product_name">
                                    <small class="text-danger" v-if="errors.product_name">{{ errors.product_name[0] }}</small>
                                    </div>
                                    <div class="col-md-6">
                                    <label for="exampleFormControlSelect1"><b>Product Code</b></label>
                                    <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Product Code" v-model="form.product_code">
                                    <small class="text-danger" v-if="errors.product_code">{{ errors.product_code[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                    <label for="exampleFormControlSelect1"><b>Product Category</b></label>
                                    <select class="form-control" id="exampleFormControlSelect1" v-model="form.catagory_id">
                                        <option :value="catagory.id" v-for="catagory in catagories">{{catagory.catagory_name}}</option>
                                    </select>
                                    </div>
                                    <div class="col-md-6">
                                    <label for="exampleFormControlSelect1"><b>Product Supplier</b></label>
                                    <select class="form-control" id="exampleFormControlSelect1" v-model="form.supplier_id">
                                        <option :value="supplier.id" v-for="supplier in suppliers">{{supplier.name}}</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                    <label for="exampleFormControlSelect1"><b>Buying Date</b></label>
                                    <input type="date" class="form-control" id="exampleInputFirstName" placeholder="Enter Your Buying Date" v-model="form.buying_date">
                                    <small class="text-danger" v-if="errors.buying_date">{{ errors.buying_date[0] }}</small>
                                    </div>
                                    <div class="col-md-6">
                                    <label for="exampleFormControlSelect1"><b>Product Quantity</b></label>
                                    <input type="text" class="form-control" id="exampleInputEmail" placeholder="Enter Your Product Quantity" v-model="form.product_quantity">
                                    <small class="text-danger" v-if="errors.product_quantity">{{ errors.product_quantity[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-4">
                                    <label for="exampleFormControlSelect1"><b>Product Root</b></label>
                                    <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Root" v-model="form.root">
                                    <small class="text-danger" v-if="errors.root">{{ errors.root[0] }}</small>
                                    </div>
                                    <div class="col-md-4">
                                    <label for="exampleFormControlSelect1"><b>Buying Price</b></label>
                                    <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Buying Price" v-model="form.buying_price">
                                    <small class="text-danger" v-if="errors.buying_price">{{ errors.buying_price[0] }}</small>
                                    </div>
                                    <div class="col-md-4">
                                    <label for="exampleFormControlSelect1"><b>Selling Price</b></label>
                                    <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Selling Price" v-model="form.selling_price">
                                    <small class="text-danger" v-if="errors.selling_price">{{ errors.selling_price[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">
                                        <small class="text-danger" v-if="errors.image">{{ errors.image[0] }}</small>
                                        <label class="custom-file-label" for="customFile"><b>Choose file</b></label>
                                    </div>
                                    <div class="col-md-6">
                                        <img :src="form.image" style="height: 40px; width: 40px;" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                            </div>
                            <br>
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
                product_name: '',
                product_code: '',
                catagory_id: '',
                supplier_id: '',
                root: '',
                buying_price: '',
                selling_price: '',
                buying_date: '',
                image: '',
                product_quantity: '',
            },
            errors:{},
            catagories:{},
            suppliers:{},
        }
    },
    created() {
        let id = this.$route.params.id
        axios.get('/api/product/'+id)
        .then(({data}) => (this.form = data))
        .catch(console.log('error'))
        
        axios.get('/api/catagory/')
        .then(({data})=> (this.catagories = data))

        axios.get('/api/supplier/')
        .then(({data})=> (this.suppliers = data))
    },
    methods: {
        onFileSelected(event){
            let file = event.target.files[0];
            if (file.size > 1048770){
                Notification.image_validation()
            }else{
                let reader = new FileReader();
                reader.onload = event =>{
                    this.form.newphoto = event.target.result;
                    //console.log(event.target.result);
                };
                reader.readAsDataURL(file);
            }
        },
        productUpdate(){
            let id = this.$route.params.id
            axios.patch('/api/product/'+id,this.form)
            .then(() => {
                this.$router.push({ name: 'product'})
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