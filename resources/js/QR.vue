<template>
    <div id="qr-reader-app" class="col-12">
        <qrcode-stream @decode="onDecode" />
    </div>
</template>
<script>
import { QrcodeStream } from "vue-qrcode-reader";

export default {
    components: { QrcodeStream },

    methods: {
        onDecode (decodedURL) {
            indow.location.href = decodedURL;
        }        
    }
}
</script>
