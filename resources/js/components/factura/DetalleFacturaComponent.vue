<template>
<div class="row">

    <div class="col-md-6">
        <div class="table-responsive">
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
                    <tr v-for="detalle in factura.detalles">
                        <th scope="row">{{ detalle.producto.id }}</th>
                        <td>{{ detalle.producto.nombre }}</td>
                        <td>${{ detalle.precio }}</td>
                        <td>{{ detalle.cantidad }}</td>
                        <td>${{ detalle.total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h2 class="text-center">Total: ${{ total }}</h2>
    </div>

    <div class="col-md-6">
        <p>numero de factura: {{ factura.id }}</p>
        <p>numero de orden: {{ factura.orden.id }}</p>
        <p>usuario: {{ factura.user.nombre }}</p>
        <p>nombre_completo: {{ factura.nombre_completo }}</p>
        <p>documento: {{ factura.documento }}</p>
        <p>tarjeta de credito: {{ factura.tarjeta_credito }}</p>
        <p>numero de articulos: {{ factura.detalles_count }}</p>
        <p>total: {{ total }}</p>
    </div>

</div>

</template>
<script>

export default {

    props: {
        factura:{
            typeof: Object
        }
    },

    computed:{
        total(){
            return this.factura.detalles.reduce((acum, current) => {
                return acum + (current.precio_unitario * current.cantidad)
            }, 0)
        }
    },

    data(){
        return {

        }
    },

}

</script>