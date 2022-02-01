<template>
    <div>
    <div class="row col-xl-3 col-lg-3 col-md-3">
        <router-link to="/store-product" class="btn btn-primary btn-sm">Add Product</router-link>
    </div>

    <br>
    <input type="text" v-model="searchTerm" class="form-control" style="width: 300px;" placeholder="Search here">
    <br>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <!-- Simple Tables -->
            <div class="card">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Stock</h6>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                    <th>Name</th>
                    <th>Photo</th>
                    <th>Category</th>
                    <th>Product Code</th>
                    <th>Buying Price</th>
                    <th>Satus</th>
                    <th>Quantity</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in filterSearch" :key="product.id">
                    <td>{{ product.product_name }}</td>
                    <td><img :src="product.photo" id="em_photo"></td>
                    <td>{{ product.catagory_id }}</td>
                    <td>{{ product.product_code }}</td>
                    <td>{{ product.buying_price }}</td>
                    <td v-if="product.product_quantity  >= 1"><span class="badge badge-success">Available</span></td>
                    <td v-else><span class="badge badge-danger">Stock Out</span></td>
                    <td>{{ product.product_quantity }}</td>
                    <td>
                        <router-link :to="{name: 'edit-stock', params:{id:product.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
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
        
        this.allProduct();
    },
    data(){
        return {
            products:[],
            searchTerm:''
        }
    },
    computed:{
        filterSearch(){
            return this.products.filter(product => {
                return product.product_name.match(this.searchTerm)
            })
        }
    },
    methods: {
        allProduct(){
            axios.get('/api/product/')
            .then(({data}) => (this.products = data))
            .catch()
        },
    },
    
}
</script>

<style type="text/css">
#em_photo{
    height: 40px;
    width: 40px;
}
</style>