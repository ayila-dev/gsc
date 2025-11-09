const cutString = (str) => {
     const strEnd = str.length;
     const strStart = str.search("<body>");
     const strResult = str.substring(strStart, strEnd);
     console.log(strResult);
     return strResult;
}