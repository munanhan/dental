import request from "../common/request";

const prefix = "/patient_categories";
//患者分类
export function get(data) {
    return request({
        url: `${prefix}`,
        method: "get",
        params: data
    });
}

export function store(data) {
    return request({
        url: `${prefix}`,
        method: "post",
        data: data
    });
}

export function del(data) {
    return request({
        url: `${prefix}/:id`,
        method: "delete",
        params: data
    });
}



