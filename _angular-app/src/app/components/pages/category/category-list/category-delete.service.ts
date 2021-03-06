import { Injectable } from "@angular/core";
import { NotifyMessageService } from "src/app/services/notify-message.service";
import { CategoryListComponent } from "./category-list.component";
import { HttpErrorResponse } from "@angular/common/http";

@Injectable({
    providedIn: 'root'
})
export class CategoryDeleteService {

    private _categoryListComponent: CategoryListComponent;

    constructor(private notifyMessage: NotifyMessageService) {

    }

    set categoryListComponent(value: CategoryListComponent) {
        this._categoryListComponent = value;
    }

    showModalDelete(categoryId: number) {
        this._categoryListComponent.categoryId = categoryId;
        this._categoryListComponent.categoryDeleteModal.showModal();
    }

    onDeleteSuccess(category: any) {
        this.notifyMessage.success('Categoria removida com sucesso.');
        this._categoryListComponent.getCategories();
    }

    onDeleteError(error: HttpErrorResponse) {
        console.log(error);
        this.notifyMessage.error('Erro ao tentar remover categoria.');
    }
}