<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">   
            <h3>Facturas</h3>
            <button type="button" class="btn btn-success" @click="descargar()" v-if="isAdmin()">descargar productos</button>
            <button type="button" class="btn btn-success" @click="crear()" v-if="isAdmin()">Crear factura</button>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" ref="facturaModal" id="facturaModal" tabindex="-1" aria-labelledby="facturaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="facturaModalLabel">{{ editando ? 'Editar': 'Crear' }} factura</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <FormFacturaComponent
                            :editando="editando"
                            :data_editar="data_editar"
                            @submit="modal.hide(), editando = false, getFacturas()"
                            @cerrar="modal.hide(), editando = false"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal detalle -->
        <div class="modal fade" ref="detalleFacturaModal" id="detalleFacturaModal" tabindex="-1" aria-labelledby="detalleFacturaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="detalleFacturaModalLabel">Detalle de factura</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <DetalleFacturaComponent
                            :factura="data_detalle"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th scope="col">id</th>
                    <th scope="col"># de orden</th>
                    <th scope="col">usuario</th>
                    <th scope="col">nombre_completo</th>
                    <th scope="col">documento</th>
                    <th scope="col">tarjeta_credito</th>
                    <th scope="col">numero de articulos</th>
                    <th scope="col">estado</th>
                    <th scope="col">acciones</th>
                </thead>
                <tbody>
                    <tr v-for="factura in facturas">
                        <th scope="row">{{ factura.id }}</th>
                        <td>{{ factura.orden ? factura.orden.id : 'Sin orden' }}</td>
                        <td>{{ factura.user.nombre }}</td>
                        <td>{{ factura.nombre_completo }}</td>
                        <td>{{ factura.documento }}</td>
                        <td>{{ factura.tarjeta_credito }}</td>
                        <td>{{ factura.detalles_count}}</td>
                        <td>{{ factura.orden ? factura.orden.estado.nombre : 'Sin orden'}}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info" @click="editar(factura)" v-if="isAdmin()">Editar</button>
                                <button class="btn btn-sm btn-warning" @click="detalle(factura)">Detalle</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <pagination :data="paginacion" :limit="2" @pagination-change-page="getFacturas"></pagination>
    </div>
    
</template>
<script>
import { Modal } from 'bootstrap'
import FormFacturaComponent from './FormFacturaComponent.vue';
import DetalleFacturaComponent from './DetalleFacturaComponent.vue';
export default {
    components: {
    FormFacturaComponent,
    DetalleFacturaComponent
},

    data(){
        return {
            facturas: [],
            paginacion: null,
            modal: null,
            modalDetalle: null,
            editando: false,
            data_editar: null,
            data_detalle: null
        }
    },

    mounted(){
        this.modal = new Modal(this.$refs.facturaModal)
        this.modalDetalle = new Modal(this.$refs.detalleFacturaModal)
        this.getFacturas();
    },

    methods: {

        async getFacturas(page = 1){
            try {
                const response = await this.axios.get('/factura?page=' + page)
                this.facturas = response.data.data
                this.paginacion = response.data
            } catch (error) {
                this.$snotify.warning('¡Hay errores con la peticion!', '¡Error!')
            }
        },

        async descargar(){
            try {
                const response = await this.axios.get('/factura/exportar', { responseType: 'blob' })
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'productos.xlsx');
                document.body.appendChild(link);
                link.click();
            }catch(error) {
                this.$snotify.warning('¡Hay errores con la peticion!', '¡Error!')
            }
        },

        detalle(factura){
            this.modalDetalle.show()
            this.data_detalle = factura
        },

        crear(){
            this.data_editar = null;
            this.editando = false;
            this.modal.show();
        },

        editar(item){
            this.data_editar = item;
            this.editando = true;
            this.modal.show();
        }

    }
}
</script>