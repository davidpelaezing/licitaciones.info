<template>
    <div class="row">

        <div class="col-lg-3">
            <h2>Filtros</h2>
            <div class="col-12">
                <select class="form-select mb-3" v-model="filtro.categoria_id" aria-label="Default select example" @change="getProductos()">
                    <option selected :value="null">Filtra por una categoria</option>
                    <option v-for="categoria in categorias" :value="categoria.id">{{ categoria.nombre }} ({{ categoria.productos_count }})</option>
                </select>
            </div>
            <div class="col-12 mb-2">
                <select class="form-select mb-3" v-model="filtro.orden" aria-label="Default select example" @change="getProductos()">
                    <option selected value="desc">Decendente</option>
                    <option selected value="asc">Asendente</option>
                </select>
            </div>

            <CarroProductoComponent 
                :orden="orden"
                @submit="miOrden()"
                v-if="Object.keys(orden).length"
            />
            
        </div>
        
        

        <div class="col-lg-9">
            <h2>Lista de productos</h2>
            <div class="row mb-4">
                <div v-for="producto in productos" class="col-lg-3 col-md-4 mb-1">
                    <CardProductoComponent
                        :producto="producto"
                        :key="producto.id"
                        @submit="miOrden()"
                    />
                </div>
            </div>
            <pagination :data="paginacion" :limit="2" @pagination-change-page="getProductos"></pagination>
        </div>

        
        
    </div>
</template>
<script>
import CarroProductoComponent from '../components/producto/CarroProductoComponent.vue';
import CardProductoComponent from '../components/producto/CardProductoComponent.vue';
export default {
    components: {
    CardProductoComponent,
    CarroProductoComponent
},

    data(){
        return {
            productos: [],
            categorias: [],
            paginacion: null,
            orden: {
                detalles: [],
            },
            filtro: {
                categoria_id: null,
                orden: "desc"
            }
        }
    },

    mounted(){
        this.getProductos()
        this.getCategorias()
        if(this.getToken()){
            this.miOrden()
        }
    },

    methods: {

        async getProductos(page = 1){
            try {
                const categoria = this.filtro.categoria_id ? this.filtro.categoria_id : '';

                const response = await this.axios.get('/producto?page=' + page + '&categoria_id=' + categoria + '&order=' + this.filtro.orden)
                this.productos = response.data.data
                this.paginacion = response.data
            } catch (error) {
                this.$snotify.warning('¡Hay errores con la peticion!', '¡Error!')
            }
        },

        async miOrden(){
            try {
                const response = await this.axios.get('/orden/mi-orden')
                this.orden = response.data
            }catch (error) {
                this.$snotify.warning('¡Hay errores con la peticion!', '¡Error!')
            }
        },

        async getCategorias() {
            try {
                const response = await this.axios.get('/categoria');
                this.categorias = response.data;
            } catch (error) {
                this.$snotify.warning('¡Hay errores con la peticion!', '¡Error!')
            }
        },

    }
}

</script>