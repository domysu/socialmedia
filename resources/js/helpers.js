export const isImage = (attachment) => {

    console.log(attachment);
    let mime = attachment.mime || attachment.type;
    mime = mime.split("/");
    return mime[0].toLowerCase() == "image";
  }