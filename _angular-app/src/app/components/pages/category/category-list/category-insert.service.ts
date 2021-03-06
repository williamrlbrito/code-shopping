import { Injectable } from "@angular/core";
import { NotifyMessageService } from "src/app/services/notify-message.service";
import { CategoryListComponent } from "./category-list.component";
import { HttpErrorResponse } from "@angular/common/http";

@Injectable({
    providedIn: 'root'
})
export class CategoryInsertService {

    private _categoryListComponent: CategoryListComponent;

    constructor(private notifyMessage: NotifyMessageService) {

    }

    set categoryListComponent(value: CategoryListComponent) {
        this._categoryListComponent = value;
    }

    showModalInsert() {
        this._categoryListComponent.categoryNewModal.showModal();
    }

    onInsertSuccess(category: any) {
        this.notifyMessage.success('Categoria cadastrada com sucesso.');
        this._categoryListComponent.getCategories();
    }

    onInsertError(error: HttpErrorResponse) {
        console.log(error);
        this.notifyMessage.error('Erro ao tentar cadastrar categoria.');
    }
}