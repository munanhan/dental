import request from "../common/request";

const prefix = "/patient_categories";
//患者分类
export function getCategory(data) {
    return request({
        url: `${prefix}`,
        method: "get",
        params: data
    });
}

export function addCategory(data) {
    return request({
        url: `${prefix}`,
        method: "post",
        data: data
    });
}

export function delCategory(data) {
    return request({
        url: `${prefix}/:id`,
        method: "delete",
        params: data
    });
}