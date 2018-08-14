import { Base } from '../../utils/base.js';

class Order extends Base{
  constructor(){
    super();
    this._storageKeyName = 'newOrder';
  }

  doOrder(param,callback){
    var that = this;
    var allParams = {
      url: 'order',
      type: 'POST',
      data: { products: param },
      sCallBack:function(data){
        that.execSetStorageSync(true);
        callback && callback(data);
      },
      eCallBack:function(){

      }
    }
    this.request(allParams);
  }
  //本地缓存 保存 更新
  execSetStorageSync(data){
    wx.setStorageSync(this._storageKeyName, data)
  }
  // 支付
  execPay(orderNumber,callback){
    var allParams = {
      url: 'pay/pre_order',
      type: 'POST',
      data: { id: orderNumber },
      sCallBack:function(data){
        var timeStamp = data.timeStamp;
        if(timeStamp){//可以支付
          wx.requestPayment({
            timeStamp: timeStamp.toString(),
            nonceStr: data.nonceStr,
            package: data.package,
            signType: data.signType,
            paySign: data.paySign,
            success:function(){
              callback && callback(2);
            },
            fail:function(){
              callback && callback(1);
            }
          })
        }else{
          callback && callback(0);
        }
      }
    }
  }
  //获得订单的具体内容
  getOrderInfoById(id,callback){
    var that = this;
    var allParams = {
      url: 'order/'+id,
      sCallBack:function(data){
        callback && callback(data)
      },
      eCallBack:function(){

      }
    }
    this.request(allParams);
  }
}

export { Order }