<template>
    <div>
    <div class="row col-xl-3 col-lg-3 col-md-3">
        <router-link to="/store-catagory" class="btn btn-primary btn-sm">Add Catagory</router-link>
    </div>

    <br>
    <input type="text" v-model="searchTerm" class="form-control" style="width: 300px;" placeholder="Search here">
    <br>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <!-- Simple Tables -->
            <div class="card">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Catagory List</h6>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                    <th>Catagory Name</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="catagory in filterSearch" :key="catagory.id">
                    <td>{{ catagory.catagory_name }}</td>
                    <td>
                        <router-link :to="{name: 'edit-catagory', params:{id:catagory.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                        <a @click="deleteCatagory(catagory.id)" class="btn btn-sm btn-danger"><font color="#ffffff">Delete</font></a>
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
    },
    data(){
        return {
            catagories:[],
            searchTerm:''
        }
    },
    computed:{
        filterSearch(){
            return this.catagories.filter(catagory => {
                return catagory.catagory_name.match(this.searchTerm)
            })
        }
    },
    methods: {
        allCatagory(){
            axios.get('/api/catagory/')
            .then(({data}) => (this.catagories = data))
            .catch()
        },
        deleteCatagory(id){
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
                    axios.delete('/api/catagory/'+id)
                    .then(() => {
                        this.catagories = this.catagories.filter(catagory => {
                            return catagory.id != id
                        })
                    })
                    .catch(() => {
                        this.$router.push({name: 'catagory'})
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
    created(){
        this.allCatagory();
    },
    
}
</script>

<style type="text/css">
#em_photo{
    height: 40px;
    width: 40px;
}
</style>