import { Component, OnInit, ViewChild } from '@angular/core';
import { HttpErrorResponse } from "@angular/common/http";
import { CategoryNewModalComponent } from '../category-new-modal/category-new-modal.component';
import { CategoryEditModalComponent } from '../category-edit-modal/category-edit-modal.component';
import { CategoryDeleteModalComponent } from '../category-delete-modal/category-delete-modal.component';
import { CategoryHttpService } from 'src/app/services/http/category-http.service';
import { Category } from 'src/app/models';

@Component({
  selector: 'category-list',
  templateUrl: './category-list.component.html',
  styleUrls: ['./category-list.component.css']
})
export class CategoryListComponent implements OnInit {

  categories: Array<Category> = [];

  @ViewChild(CategoryNewModalComponent)
  categoryNewModal: CategoryNewModalComponent;

  @ViewChild(CategoryEditModalComponent)
  categoryEditModal: CategoryEditModalComponent;

  @ViewChild(CategoryDeleteModalComponent)
  categoryDeleteModal: CategoryDeleteModalComponent;

  categoryId: number;

  constructor(private CategoryHttp: CategoryHttpService) {

  }

  ngOnInit() {
    this.getCategories();
  }

  getCategories() {
    const token = window.localStorage.getItem('token');
    this.CategoryHttp.list()
      .subscribe((response) => {
        this.categories = response.data;
      });
  }

  showModalInsert() {
    this.categoryNewModal.showModal();
  }

  showModalEdit(categoryId: number) {
    this.categoryId = categoryId;
    this.categoryEditModal.showModal();
  }

  showModalDelete(categoryId: number) {
    this.categoryId = categoryId;
    this.categoryDeleteModal.showModal();
  }

  onInsertSuccess(category: any) {
    console.log(category);
    this.getCategories();
  }

  onInsertError(error: HttpErrorResponse) {
    console.log(error);
  }

  onEditSuccess(category: any) {
    console.log(category);
    this.getCategories();
  }

  onEditError(error: HttpErrorResponse) {
    console.log(error);
  }

  onDeleteSuccess(category: any) {
    console.log(category);
    this.getCategories();
  }

  onDeleteError(error: HttpErrorResponse) {
    console.log(error);
  }

}
