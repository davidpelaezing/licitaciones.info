<template>

<div class="card">
    <div class="card-header">
        Mi carrito
    </div>
    <div class="card-body">
        
        <div class="table-responsive" v-if="orden.detalles.length">
            <table class="table table-striped mb-2">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">producto</th>
                        <th scope="col">precio</th>
                        <th scope="col">cantidad</th>
                        <th scope="col">total</th>
                        <th scope="col">accion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="detalle in orden.detalles">
                        <th scope="row">{{ detalle.producto.id }}</th>
                        <td>{{ detalle.producto.nombre }}</td>
                        <td>${{ detalle.producto.precio }}</td>
                        <td>{{ detalle.cantidad }}</td>
                        <td>${{ detalle.cantidad * detalle.producto.precio }}</td>
                        <td><button class="btn btn-sm btn-danger" @click.prevent="eliminar(detalle)">x</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3>Total: ${{ total }}</h3>

        <button class="btn btn-primary" @click="pagar()" v-if="orden.detalles.length">Pagar</button>

    </div>
</div>

</template>
<script>
import FormFacturaComponent from '../factura/FormFacturaComponent.vue';
export default {
    components: { FormFacturaComponent },

    props: {
        orden: {
            type: Object,
            default: {
                detalles: []
            }
        }
    },

    computed:{
        total(){
            return this.orden.detalles.reduce((acum, current) => {
                return acum + (current.producto.precio * current.cantidad)
            }, 0)
        }
    },

    methods: {

        async eliminar(detalle){
            try {
                await this.axios.delete('/orden/eliminar-producto/' + detalle.id)
                this.$emit('submit');
            }catch(error){
                console.log(error)
            }
        },

        pagar(){
            this.$router.push('/finalizar-compra')
        }

    },
}

</script>