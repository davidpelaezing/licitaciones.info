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

        <button class="btn btn-primary">Realizar Compra</button>

    </div>
</div>

</template>
<script>

export default {

    props: {
        orden: {
            type: Object
        }
    },

    methods: {

    }

}

</script>