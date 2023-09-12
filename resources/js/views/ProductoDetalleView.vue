<template>
    <div class="row">
        <div class="col-md-7">
            <DetalleProductoComponent 
                :producto="producto"
            />
        </div>
        <div class="col-md-5">
            <ComentarioProductoComponent 
                :producto="producto"
                @submit="getProducto()"
            />
        </div>
        
    </div>
</template>
<script>
import DetalleProductoComponent from '../components/producto/DetalleProductoComponent.vue';
import ComentarioProductoComponent from '../components/producto/ComentarioProductoComponent.vue';

export default {

    components: { DetalleProductoComponent, ComentarioProductoComponent },

    data(){
        return {
            producto: null
        }
    },

    created(){
        this.getProducto()
    },

    methods: {

        async getProducto(){
            try {
                const response = await this.axios.get('/producto/consultar/' +  this.$route.params.id)
                this.producto = response.data
            }catch(error){
                console.log(error.response)
            }
        }

    }

}
</script>