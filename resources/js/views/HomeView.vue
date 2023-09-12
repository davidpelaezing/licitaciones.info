<template>
    <div class="row">
        <div class="col-md-6">
            <h2>Lista de productos</h2>

            <select class="form-select mb-3" v-model="filtro.categoria_id" aria-label="Default select example" @change="getProductos()">
                <option selected :value="null">Filtra por una categoria</option>
                <option v-for="categoria in categorias" :value="categoria.id">{{ categoria.nombre }}</option>
            </select>

            <div class="row mb-4">
                <div v-for="producto in productos" class="col-lg-4 col-md-6">
                    <CardProductoComponent
                        :producto="producto"
                        :key="producto.id"
                        @submit="miOrden()"
                    />
                </div>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#" @click.prevent="getProductos(paginacion.current_page - 1)">Anterior</a></li>
                    <li class="page-item" v-for="page in paginacion.last_page"><a class="page-link" href="#" @click.prevent="getProductos(page)">{{ page }}</a></li>
                    <li class="page-item"><a class="page-link" href="#" @click.prevent="getProductos(paginacion.current_page + 1)">Siguiente</a></li>
                </ul>
            </nav>
        </div>
        <div class="col-md-4">
            <h2>Mi carrito</h2>
            <CarroProductoComponent 
                :orden="orden"
            />
        </div>
    </div>
</template>
<script>
import CardProductoComponent from '../components/producto/CardProductoComponent.vue';
import CarroProductoComponent from '../components/producto/CarroProductoComponent.vue';
export default {
    components: {
    CardProductoComponent,
    CarroProductoComponent
},

    data(){
        return {
            productos: [],
            categorias: [],
            orden: null,
            paginacion:{
                current_page: 1,
                last_page: 1
            },
            filtro: {
                categoria_id: null
            }
        }
    },

    mounted(){
        this.getProductos()
        this.getCategorias()
        this.miOrden()
    },

    methods: {

        async getProductos(page = 1){
            try {

                /** validamos la paginacion */
                if(page > this.paginacion.last_page || page < 1){
                    return false;
                }

                const categoria = this.filtro.categoria_id ? this.filtro.categoria_id : '';

                const response = await this.axios.get('/producto?page=' + page + '&categoria_id=' + categoria)
                this.paginacion.current_page = response.data.current_page
                this.paginacion.last_page = response.data.last_page
                this.productos = response.data.data
            } catch (error) {
                console.log(error.response)
            }
        },

        async miOrden(){
            try {
                const response = await this.axios.get('/orden/mi-orden')
                this.orden = response.data
            }catch (error) {
                console.log(error.response)
            }
        },

        async getCategorias() {
            try {
                const response = await this.axios.get('/categoria');
                this.categorias = response.data;
            } catch (error) {
                console.log(error)
            }
        },

    }
}

</script>