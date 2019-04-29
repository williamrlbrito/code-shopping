import { Injectable } from "@angular/core";
import { NotifyMessageService } from "src/app/services/notify-message.service";
import { CategoryListComponent } from "./category-list.component";
import { HttpErrorResponse } from "@angular/common/http";

@Injectable({
    providedIn: 'root'
})
export class CategoryEditService {

    private _categoryListComponent: CategoryListComponent;

    constructor(private notifyMessage: NotifyMessageService) {

    }

    set categoryListComponent(value: CategoryListComponent) {
        this._categoryListComponent = value;
    }

    showModalEdit(categoryId: number) {
        this._categoryListComponent.categoryId = categoryId;
        this._categoryListComponent.categoryEditModal.showModal();
    }

    onEditSuccess(category: any) {
        this.notifyMessage.success('Categoria alterada com sucesso.');
        this._categoryListComponent.getCategories();
    }

    onEditError(error: HttpErrorResponse) {
        console.log(error);
        this.notifyMessage.error('Erro ao tentar alterar categoria.');
    }
}