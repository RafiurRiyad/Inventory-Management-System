<template>
    <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">POS Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">POS</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">
            <!-- Area Chart -->
            <div class="col-xl-5 col-lg-5">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Expense Insert</h6>
                    <a class="btn btn-sm btn-info"><font color="#fff">Add Customer</font></a>
                </div>
                <div class="table-responsive" style="font-size: 12px;">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="cart in carts" :key="cart.id">
                        <td>{{cart.product_name}}</td>
                        <td><input type="text" readonly :value="cart.product_quantity" style="width: 15px;">
                        <button @click.prevent="increment(cart.id)" class="btn btn-success">+</button>
                        <button @click.prevent="decrement(cart.id)" class="btn btn-danger" v-if="cart.product_quantity >= 2">-</button>
                        <button class="btn btn-sm btn-danger" v-else disabled>-</button>
                        </td>
                        <td>{{cart.product_price}}</td>
                        <td>{{cart.sub_total}}</td>
                        <td><a @click="removeItem(cart.id)" class="btn btn-sm btn-primary"><font color="#ffffff">X</font></a></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <div class="card-footer">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Quantity:
                            <strong>{{ qty}}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Sub Total:
                            <strong>{{ sub_total }} $</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Vat:
                            <strong>{{ vats.vat }} %</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total:
                            <strong>{{ sub_total + (sub_total * (vats.vat/100))}} $</strong>
                        </li>
                    </ul>
                    <br><br>
                    <form @submit.prevent="orderDone">
                        <label for="name">Customer Name</label>
                        <select class="form-control" v-model="customer_id">
                            <option value="customer.id" v-for="customer in customers"> {{ customer.name }}</option>
                        </select>
                        <label for="pay">Pay</label>
                        <input type="text" class="form-control" required v-model="pay">
                        <label for="due">Due</label>
                        <input type="text" class="form-control" required v-model="due">
                        <label for="payby">Pay By</label>
                        <select class="form-control" v-model="payby">
                            <option value="Cheque">Cheque</option>
                            <option value="HandCash">Hand Cash</option>
                            <option value="Card">Card</option>
                            <option value="GiftCard">Gift Card</option>
                        </select>
                        <br>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
              </div>
            </div>
            <!-- Pie Chart -->
            <div class="col-xl-7 col-lg-7">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>
                </div>
                    <!-- Catagory Wise Products-->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All Products</a>
                    </li>
                    <li class="nav-item" v-for="catagory in catagories" :key="catagory.id">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" @click="subProduct(catagory.id)">{{ catagory.catagory_name }}</a>
                    </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card-body">
                            <br>
                            <input type="text" v-model="searchTerm" class="form-control" style="width: 500px;" placeholder="Search Products">
                            <br>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="product in filterSearch" :key="product.id">
                                    <button class="btn btn-sm" @click.prevent="AddToCart(product.id)">
                                    <div class="card" style="width: 8.5rem; margin-bottom:5px;">
                                        <img class="card-img-top" :src="product.image" id="em_photo" >
                                        <div class="card-body">
                                            <h6 class="card-title">{{ product.product_name }}</h6>
                                            <span class="badge badge-success"  v-if="product.product_quantity  >= 1">Available {{ product.product_quantity }}</span>
                                            <span class="badge badge-danger" v-else>Stock Out</span>
                                        </div>
                                    </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card-body">
                            <br>
                            <input type="text" v-model="searchTerm" class="form-control" style="width: 500px;" placeholder="Search Products">
                            <br>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="product in getFilterSearch" :key="product.id">
                                    <button class="btn btn-sm" @click.prevent="AddToCart(product.id)">
                                    <div class="card" style="width: 8.5rem; margin-bottom:5px;">
                                        <img class="card-img-top" :src="product.image" id="em_photo" >
                                        <div class="card-body">
                                            <h6 class="card-title">{{ product.product_name }}</h6>
                                            <span class="badge badge-success"  v-if="product.product_quantity  >= 1">Available {{ product.product_quantity }}</span>
                                            <span class="badge badge-danger" v-else>Stock Out</span>
                                        </div>
                                    </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Catagory wise products end -->
              </div>
            </div>
          </div>
          <!--Row-->
        </div>
</template>

<script type="text/javascript">
export default {
    created(){
        if(!User.loggedIn()){
            this.$router.push({ name: '/'})
        }
    },
    created() {
        this.allProduct();
        this.allCatagory();
        this.allCustomer();
        this.cartProduct();
        this.vat();
        Reload.$on('AfterAdd', () =>{
            this.cartProduct()
        })
    },
    data(){
        return {
            errors: '',
            products:[],
            catagories:[],
            get_products:[],
            searchTerm:'',
            getSearchTerm:'',
            customers:'',
            carts:[],
            vats: [],
        }
    },
    computed:{
        filterSearch(){
            return this.products.filter(product => {
                return product.product_name.match(this.searchTerm)
            })
        },
        getFilterSearch(){
            return this.get_products.filter(get_product => {
                return get_product.product_name.match(this.searchTerm)
            })
        },
        qty(){
            let sum = 0;
            for (let i = 0; i < this.carts.length; i++) {
                sum += (parseFloat(this.carts[i].product_quantity));
            }
            return sum;
        },
        sub_total(){
            let sum = 0;
            for (let i = 0; i < this.carts.length; i++) {
                sum += (parseFloat(this.carts[i].sub_total));
            }
            return sum;
        },
    },
    methods: {
        allProduct(){
            axios.get('/api/product')
            .then(({data}) => (this.products = data))
            .catch()
        },
        allCatagory(){
            axios.get('/api/catagory')
            .then(({data}) => (this.catagories = data))
            .catch()
        },
        allCustomer(){
            axios.get('/api/customer')
            .then(({data}) => (this.customers = data))
            .catch()
        },
        subProduct(id){
            axios.get('/api/getting/product/'+id)
            .then(({data}) => (this.get_products = data))
            .catch()
        },
        //cart methods
        AddToCart(id){
            axios.get('/api/add-to-cart/'+id)
            .then(() => {
                Reload.$emit('AfterAdd')
                Notification.cart_success();
            })
            .catch()
        },
        cartProduct(){
            axios.get('/api/cart/product/')
            .then(({data}) => (this.carts = data))
            .catch()
        },
        removeItem(id){
            axios.get('/api/remove/cart/'+id)
            .then(() => {
                Reload.$emit('AfterAdd')
                Notification.cart_remove();
            })
            .catch()
        },
        increment(id){
            axios.get('/api/increment/'+id)
            .then(() => {
                Reload.$emit('AfterAdd')
                Notification.success();
            })
            .catch()
        },
        decrement(id){
            axios.get('/api/decrement/'+id)
            .then(() => {
                Reload.$emit('AfterAdd')
                Notification.success();
            })
            .catch()
        },
        vat(){
            axios.get('/api/vat/')
            .then(({data}) => (this.vats = data))
            .catch()
        },
    },
    
}
</script>

<style type="text/css" scoped>
#em_photo{
    height: 100px;
    width: 135px;
}
</style>