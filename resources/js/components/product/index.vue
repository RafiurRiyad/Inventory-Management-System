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
                <h6 class="m-0 font-weight-bold text-primary">Product List</h6>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                    <th>Name</th>
                    <th>Photo</th>
                    <th>Catagory</th>
                    <th>Product Code</th>
                    <th>Buying Price</th>
                    <th>Selling Price</th>
                    <th>Root</th>
                    <th>Supplier Name</th>
                    <th>Buying Date</th>
                    <th>Product Quantity</th>
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
                    <td>{{ product.selling_price }}</td>
                    <td>{{ product.root }}</td>
                    <td>{{ product.supplier_id }}</td>
                    <td>{{ product.buying_date }}</td>
                    <td>{{ product.product_quantity }}</td>
                    <td>
                        <router-link :to="{name: 'edit-product', params:{id:product.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                        <a @click="deleteProduct(product.id)" class="btn btn-sm btn-danger"><font color="#ffffff">Delete</font></a>
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
        deleteProduct(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/product/'+id)
                    .then(() => {
                        this.products = this.products.filter(product => {
                            return product.id != id
                        })
                    })
                    .catch(() => {
                        this.$router.push({name: 'product'})
                    })
                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    )
                }
})
        }
    },
    
}
</script>

<style type="text/css">
#em_photo{
    height: 40px;
    width: 40px;
}
</style>