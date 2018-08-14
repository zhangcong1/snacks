import { Base } from 'base.js';
import { Config } from 'config.js';
class Address extends Base{
  constructor(){
    super()
  }

  setAddressInfo(res){
    var province = res.provinceName || res.province,
        city = res.cityName || res.city,
        county = res.countyName || res.country,
        detail = res.detailInfo || res.detail;
    var totalDetail = city + county + detail;
    if(!this.isCenterCity(province)){
      totalDetail = province + totalDetail;
    }
    return totalDetail;
  }
  // 是否为直辖市
  isCenterCity(name){
    var centerCitys = ['北京市','天津市','上海市','重庆市'],
    flag = centerCitys.indexOf(name) >= 0;
    return flag;
  }
  // 更新保存地址
  submitAddress(data,callback){
    data = this._setUpAddress(data);
    var param = {
      url: 'address',
      type: 'post',
      data: data,
      sCallBack:function(res){
        callback && callback(true,res);
      },
      eCallBack:function(res){
        callback && callback(false, res);
      }
    }
    this.request(param);
  }
  //保存地址
  _setUpAddress(res){
    var formData = {
      name: res.userName,
      province: res.provinceName,
      city: res.cityName,
      country: res.countyName,
      mobile: res.telNumber,
      detail:res.detailInfo
    };
    return formData;
  }
  //获取用户地址
  getAddress(callback){
    var that = this;
    var param = {
      url: 'address',
      sCallBack:function(res){
        if(res){
          res.totalDetail = that.setAddressInfo(res);
          callback && callback(res);
        }
      }
    }
    this.request(param);
  }
}

export {Address}