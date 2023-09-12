<template>

<div class="card">
    <div class="card-body">
        <ol class="list-group list-group-numbered mb-3">
            <li v-for="detalle in orden.detalles" class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                <div class="fw-bold">{{ detalle.producto.nombre }}</div>
                    {{ detalle.cantidad }} unidades
                    <span class="badge bg-primary rounded-pill">${{ detalle.cantidad * detalle.producto.precio }}</span>
                </div>
                
                <button class="btn btn-sm btn-danger" @click.prevent="eliminar(detalle)">x</button>
            </li>
        </ol>

        <h3>Total: ${{ total }}</h3>

        <button class="btn btn-primary" @click="pagar()">Pagar</button>

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