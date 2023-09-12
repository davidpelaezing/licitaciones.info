<template>

<div class="card">
    <div class="card-body">
        <ol class="list-group list-group-numbered mb-3">
            <li v-for="detalle in orden.detalles" class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                <div class="fw-bold">{{ detalle.producto.nombre }}</div>
                    {{ detalle.cantidad }} unidades
                </div>
                <span class="badge bg-primary rounded-pill">${{ detalle.cantidad * detalle.producto.precio }}</span>
            </li>
        </ol>

        <h3>Total: ${{ total }}</h3>

        <button class="btn btn-primary" @click="pagar()">Realizar Compra</button>

        <!-- Modal -->
        <div class="modal fade" ref="facturaModal" id="facturaModal" tabindex="-1" aria-labelledby="facturaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="facturaModalLabel">Pagando factura</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <table class="table table-striped mb-2">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">producto</th>
                                    <th scope="col">precio_unitario</th>
                                    <th scope="col">cantidad</th>
                                    <th scope="col">total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="detalle in orden.detalles">
                                    <th scope="row">{{ detalle.producto.id }}</th>
                                    <td>{{ detalle.producto.nombre }}</td>
                                    <td>${{ detalle.producto.precio }}</td>
                                    <td>{{ detalle.cantidad }}</td>
                                    <td>${{ detalle.cantidad * detalle.producto.precio }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</template>
<script>
import FormFacturaComponent from '../factura/FormFacturaComponent.vue';
import { Modal } from 'bootstrap'
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

    data() {
        return {
            modal: 'pito'
        };
    },

    mounted() {
        this.modal = new Modal(this.$refs.facturaModal)
    },

    computed:{
        total(){
            return this.orden.detalles.reduce((acum, current) => {
                return acum + (current.producto.precio * current.cantidad)
            }, 0)
        }
    },

    methods: {

        pagar(){
            this.modal.show()
        }

    },
}

</script>