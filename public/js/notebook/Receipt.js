class Receipt{
    constructor(tDate = null,vid = null,vendor = null){
        this.tDate = tDate;
        this.vid = vid;
        this.items = [];
        this.vendor = vendor;
        this.totalNetPrice = 0;
    }
    addItem(item){
        this.items.push(item);
    }

    addItems(...itemsArray){
        itemsArray.forEach(element => {
            //check is item exists in current items
            this.items.push(element);
        });
    }

    deleteItemByItemNo(itemno){
        var toDeleteIndex = this.searchItem('itemno',itemno);
        if (toDeleteIndex !== false) {
            this.items.splice(toDeleteIndex,1);
        }
    }

    deleteItemByIndex(index){
        this.items.splice(index,1);
    }

    clearItems(){
        this.items = [];
    }

    searchItem(objectproperty,tosearch){
        var found = false;
        var indexFound = 0;
        for (let index = 0; index < this.items.length; index++) {
            const element = this.items[index];
            if (element[objectproperty] === tosearch) {
                found = true;
                indexFound = index;
                break;
            }
        }
        if (found) {
            return indexFound;
        }else{
            return false;
        }
    }

    getItems(){
        return this.items;
    }

    getItemByIndex(index){
        if (index < 0 || index<this.items.length) {
            return this.items[index];
        }else{
            return false;
        }
    }

    getDate(){
        return this.tDate;
    }

    getVendor(){
        return this.vendor;
    }

    getVid(){
        return this.vid;
    }

    setVendor(vid,vendor){
        this.vid = vid;
        this.vendor = vendor;
    }

    generate(withControls = null){
        var htmlString = "";
        if(this.getItems().length > 0){
            this.items.forEach(function(value,i) {
                if (withControls != null && withControls == true) {
                    var toAddString = `<tr>
                    <td class="itemColumn text-center">${value.itemdesc}</td>
                    <td class="baseColumn text-center">${value.base}</td>
                    <td class="d1Column text-center">${value.d1}</td>
                    <td class="d2Column text-center">${value.d2}</td>
                    <td class="d3Column text-center">${value.d3}</td>
                    <td class="d4Column text-center">${value.d4}</td>
                    <td class="netpriceColumn text-center">${value.netprice}</td>
                </tr>`;
                }else{
                    var toAddString = `<tr>
                    <td class="itemColumn text-center">${value.itemdesc}</td>
                    <td class="baseColumn text-center">${value.base}</td>
                    <td class="d1Column text-center">${value.d1}</td>
                    <td class="d2Column text-center">${value.d2}</td>
                    <td class="d3Column text-center">${value.d3}</td>
                    <td class="d4Column text-center">${value.d4}</td>
                    <td class="netpriceColumn text-center">${value.netprice}</td>
                    <td class="text-center">
                        <a href="#" class="deleteItem text-danger ${i} control"><i class="fas fa-times-circle"></i></a>
                        <a href="#" class="editItem text-primary ${i} ${value.itemno} control"><i class="fas fa-pencil-alt"></i></a>
                    </td>
                    </tr>`;
                }
                htmlString = htmlString + toAddString;
            });

        }
        return htmlString;

    }

    getTotalNetPrice(){
        var totalPrice = 0;
        this.items.forEach(function(value,i) {
            totalPrice = totalPrice + parseFloat(value.netprice);
        });
        return totalPrice.toFixed(2);
    }

    setTotalNetPrice(){
        this.totalNetPrice = this.getTotalNetPrice();
    }

    updateItem(index,item){
        var toUpdateItem = this.getItemByIndex(index);
        if (toUpdateItem != false) {
            toUpdateItem.setItem(item.itemno,item.itemdesc,item.base,item.d1,
                item.d2,item.d3, item.d4,item.netprice
            );
            return true;
        }else{
            return false;
        }
    }


}