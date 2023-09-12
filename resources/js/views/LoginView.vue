<template>
    <div class="row">
        <div class="col-md-5 mx-auto">
            <h2>Login</h2>
            <FormLoginComponent />
        </div>
    </div>
</template>
<script>
import FormLoginComponent from '../components/login/FormLoginComponent.vue';

export default {

    components: { FormLoginComponent }

}
</script>