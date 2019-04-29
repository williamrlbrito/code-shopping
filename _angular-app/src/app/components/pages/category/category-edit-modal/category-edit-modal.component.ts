import { Component, OnInit, ViewChild, Input, Output, EventEmitter } from '@angular/core';
import { ModalComponent } from 'src/app/components/bootstrap/modal/modal.component';
import { HttpErrorResponse, HttpClient } from '@angular/common/http';
import { Category } from 'src/app/models';
import { CategoryHttpService } from 'src/app/services/http/category-http.service';

@Component({
  selector: 'category-edit-modal',
  templateUrl: './category-edit-modal.component.html',
  styleUrls: ['./category-edit-modal.component.css']
})
export class CategoryEditModalComponent implements OnInit {

  category: Category = {
    name: '',
    active: true
  }

  _categoryId: number;

  @ViewChild(ModalComponent) modal: ModalComponent;
  @Output() onSuccess: EventEmitter<any> = new EventEmitter<any>();
  @Output() onError: EventEmitter<HttpErrorResponse> = new EventEmitter<HttpErrorResponse>();

  constructor(private categoryHttp: CategoryHttpService) { }

  ngOnInit() {
  }

  @Input()
  set categoryId(value) {
    this._categoryId = value;
    if (this._categoryId) {
      this.categoryHttp
        .get(this._categoryId)
        .subscribe(category => this.category = category);
    }
  }

  submit() {
    this.categoryHttp
      .create(this.category)
      .subscribe((category) => {
        this.onSuccess.emit(category);
        this.modal.hide();
      }, error => this.onError.emit(error));
  }

  showModal() {
    this.modal.show();
  }

  hideModal(e: Event) {
    console.log(e);
  }

}
