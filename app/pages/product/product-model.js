import { Base } from '../../utils/base.js';

class Product extends Base {
  constructor() {
    super();
  }
  // 获取主题下的商品列表
  getDetailInfo(id, callback) {
    var params = {
      url: 'product/' + id,
      sCallBack: function (res) {
        callback && callback(res);
      }
    };
    this.request(params);
  }
}

export { Product }