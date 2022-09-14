<template>
    <button type="button" class="btn btn-success m-2" @click='save()'>保存</button>
</template>

<script>
export default {
    props: {
        fileName: {
            type: String,
            required: true
        }
    },
    methods: {
        save() {
            // <html>をclone
            const html = document.getElementsByTagName('html')[0].cloneNode(true);

            // hrefやsrcに指定されたURLを絶対パスに変換
            const nodes = html.querySelectorAll('[href],[src]');
            for (let i=0, n=nodes.length; i<n; i++) {
                if (nodes[i].href) { nodes[i].href=nodes[i].href; }
                if (nodes[i].src) { nodes[i].src=nodes[i].src; }
            }

            // ソースコードをテキストで取得
            const src = html.innerHTML;

            // DOCTYPEを作成
            const name     = document.doctype.name;
            const publicId = document.doctype.publicId;
            const systemID = document.doctype.systemId;
            const doctype  = '<!DOCTYPE ' + name
                            + (publicId ? ' PUBLIC "' + publicId + '"' : '')
                            + (systemID ? ' "' + systemID + '"' : '')
                            + '>';

            // <html> タグを再構成
            let htmlTag = '<html';
            const attrs = html.attributes;
            for (let i=0, n=attrs.length; i<n; i++) {
                const attr = attrs[i];
                htmlTag += ' ' + attr.nodeName + (attr.nodeValue ? '="' + attr.nodeValue + '"' : '');
            }
            htmlTag += '>';

            // ソースコードを Blob オブジェクトに変換してURLを取得
            const blob    = new Blob([doctype, '\n', htmlTag, '\n', src, '\n</html>']);
            const url     = window.URL || window.webkitURL;
            const blobURL = url.createObjectURL(blob);

            // ダウンロード
            const a = document.createElement('a');
            a.download = `${this.fileName}.html`;
            a.href = blobURL;
            a.click();
        }
    }
}
</script>
