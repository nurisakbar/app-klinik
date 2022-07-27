<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Lang - English
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Author: Daniel Davis
*         @ourmaninjapan
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.09.2013
*
* Description:  English language file for Ion Auth example views
*
*/

// Errors
$lang['error_csrf'] = 'This form post did not pass our security checks.';

// Login
$lang['login_heading']         = 'Login';
$lang['login_subheading']      = 'Selamat Datang';
$lang['login_identity_label']  = 'Email/Username';
$lang['login_password_label']  = 'Password';
$lang['login_remember_label']  = 'Remember Me';
$lang['login_submit_btn']      = 'Sign In';
$lang['login_forgot_password'] = 'Forgot your password?';

// Index
$lang['index_heading']           		= 'Pengguna';
$lang['index_subheading']        		= 'Di bawah ini adalah daftar pengguna.';
$lang['index_fname_th']          		= 'Nama Depan';
$lang['index_lname_th']          		= 'Nama Belakang';
$lang['index_email_th']          		= 'Email';
$lang['index_groups_th']         		= 'Grup';
$lang['index_status_th']         		= 'Status';
$lang['index_action_th']         		= 'Aksi';
$lang['index_active_link']      		= 'Aktif';
$lang['index_inactive_link']    		= 'Nonaktif';
$lang['index_groups_anchor_tooltip']  	= 'Edit Perizinan Grup';
$lang['index_delete_user_icon']  		= 'Hapus Akun';
$lang['index_edit_user_icon']  			= 'Edit Akun';
$lang['index_create_user_btn_label']  	= 'Tambah Pengguna';
$lang['index_create_group_btn_label'] 	= 'Tambah Grup';


// Deactivate User
$lang['deactivate_heading']                  = 'Deactivate User';
$lang['deactivate_subheading']               = 'Are you sure you want to deactivate the user \'%s\'';
$lang['deactivate_confirm_y_label']          = 'Yes:';
$lang['deactivate_confirm_n_label']          = 'No:';
$lang['deactivate_submit_btn']               = 'Submit';
$lang['deactivate_validation_confirm_label'] = 'confirmation';
$lang['deactivate_validation_user_id_label'] = 'user ID';

// Create User
$lang['create_user_heading']                           = 'Tambah Pengguna';
$lang['create_user_subheading']                        = 'Silahkan masukkan informasi pengguna di bawah ini.';
$lang['create_user_fname_label']                       = 'Nama Depan:';
$lang['create_user_lname_label']                       = 'Nama Belakang:';
$lang['create_user_company_label']                     = 'Nama Perusahaan:';
$lang['create_user_identity_label']                    = 'Identitas:';
$lang['create_user_email_label']                       = 'Email:';
$lang['create_user_phone_label']                       = 'Telepon:';
$lang['create_user_username_label']                    = 'Nama Pengguna:';
$lang['create_user_password_label']                    = 'Kata Sandi:';
$lang['create_user_password_confirm_label']            = 'Konfirmasi Kata Sandi:';
$lang['create_user_submit_btn']                        = 'Simpan';
$lang['create_user_cancel_btn']                        = 'Batal';
$lang['create_user_validation_fname_label']            = 'Nama Depan';
$lang['create_user_validation_lname_label']            = 'Nama Belakang';
$lang['create_user_validation_identity_label']         = 'Identitas';
$lang['create_user_validation_email_label']            = 'Alamat Email';
$lang['create_user_validation_phone_label']            = 'Telepon';
$lang['create_user_validation_company_label']          = 'Nama Perusahaan';
$lang['create_user_validation_username_label']         = 'Nama Pengguna';
$lang['create_user_validation_password_label']         = 'Kata Sandi';
$lang['create_user_validation_password_confirm_label'] = 'Konfirmasi Kata Sandi';
$lang['create_user_uploadprofilepicture_label']        = 'Pilih Foto Profil';
$lang['create_user_accessibleAccounts_label']          = 'Akses Akun';
$lang['create_user_accessibleAccounts_frst_option']    = 'Semua Akun';
$lang['create_user_accessibleAccounts_placeholder']    = 'Pilih Akun';
$lang['create_user_accessibleAccounts_frst_option']    = 'Semua Akun';


// Edit User
$lang['edit_user_heading']                           = 'Edit Pengguna';
$lang['edit_user_subheading']                        = 'Silahkan masukkan informasi pengguna di bawah ini.';
$lang['edit_user_fname_label']                       = 'Nama Depan:';
$lang['edit_user_lname_label']                       = 'Nama Belakang:';
$lang['edit_user_company_label']                     = 'Nama Perusahaan:';
$lang['edit_user_email_label']                       = 'Alamat Email:';
$lang['edit_user_phone_label']                       = 'Telepon:';
$lang['edit_user_password_label']                    = 'Kata Sandi: (isi jika ingin diganti)';
$lang['edit_user_password_confirm_label']            = 'Konfirmasi Kata Sandi: (isi jika ingin diganti)';
$lang['edit_user_groups_heading']                    = 'Grup Akses';
$lang['edit_user_submit_btn']                        = 'Perbarui';
$lang['edit_user_cancel_btn']                        = 'Batal';
$lang['edit_user_validation_fname_label']            = 'Nama Depan';
$lang['edit_user_validation_lname_label']            = 'Nama Belakang';
$lang['edit_user_validation_email_label']            = 'Alamat Email';
$lang['edit_user_validation_phone_label']            = 'Telepon';
$lang['edit_user_validation_company_label']          = 'Nama Perusahaan';
$lang['edit_user_validation_groups_label']           = 'Grup';
$lang['edit_user_validation_password_label']         = 'Kata Sandi';
$lang['edit_user_validation_password_confirm_label'] = 'Konfirmasi Kata Sandi';
$lang['edit_user_updateuserimage_btn_label']       	 = 'Ganti Foto Profil';
$lang['edit_user_modal_title']       				 = 'Ganti Foto Profil';
$lang['edit_user_userimageupdate_label']       	 	 = 'Pilih Gambar';
$lang['create_user_accessibleAccounts_label']        = 'Akses Akun';
$lang['create_user_accessibleAccounts_frst_option']  = 'Semua Akun';
$lang['create_user_accessibleAccounts_placeholder']  = 'Pilih Akun';
$lang['create_user_accessibleAccounts_frst_option']  = 'Semua Akun';
$lang['edit_user_modal_submit_btn_label']         	 = 'Perbarui';
$lang['edit_user_modal_cancel_btn_label']         	 = 'Batal';


// Create Group
$lang['create_group_title']                  = 'Buat Grup';
$lang['create_group_heading']                = 'Buat Grup';
$lang['create_group_subheading']             = 'Silahkan masukkan informasi grup di bawah ini.';
$lang['create_group_name_label']             = 'Nama Grup:';
$lang['create_group_desc_label']             = 'Keterangan:';
$lang['create_group_submit_btn']             = 'Buat Grup';
$lang['create_group_validation_name_label']  = 'Nama Grup';
$lang['create_group_validation_desc_label']  = 'Keterangan';
$lang['create_group_submit_button']          = 'Simpan';
$lang['create_group_cancel_button']          = 'Batal';

// Edit Group
$lang['edit_group_title']                  = 'Edit Grup';
$lang['edit_group_saved']                  = 'Grup Disimpan';
$lang['edit_group_heading']                = 'Edit Grup';
$lang['edit_group_subheading']             = 'Silahkan masukkan informasi grup di bawah ini.';
$lang['edit_group_name_label']             = 'Nama Grup:';
$lang['edit_group_desc_label']             = 'Keterangan:';
$lang['edit_group_submit_btn']             = 'Simpan Grup';
$lang['edit_group_validation_name_label']  = 'Nama Grup';
$lang['edit_group_validation_desc_label']  = 'Keterangan';
$lang['edit_group_submit_button']          = 'Perbarui';
$lang['edit_group_cancel_button']          = 'Batal';

// Change Password
$lang['change_password_heading']                               = 'Change Password';
$lang['change_password_old_password_label']                    = 'Old Password:';
$lang['change_password_new_password_label']                    = 'New Password (at least %s characters long):';
$lang['change_password_new_password_confirm_label']            = 'Confirm New Password:';
$lang['change_password_submit_btn']                            = 'Change';
$lang['change_password_validation_old_password_label']         = 'Old Password';
$lang['change_password_validation_new_password_label']         = 'New Password';
$lang['change_password_validation_new_password_confirm_label'] = 'Confirm New Password';

// Forgot Password
$lang['forgot_password_heading']                 = 'Forgot Password';
$lang['forgot_password_subheading']              = 'Please enter your %s so we can send you an email to reset your password.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'Submit';
$lang['forgot_password_validation_email_label']  = 'Email Address';
$lang['forgot_password_identity_label'] = 'Identity';
$lang['forgot_password_email_identity_label']    = 'Email';
$lang['forgot_password_email_not_found']         = 'No record of that email address.';

// Reset Password
$lang['reset_password_heading']                               = 'Change Password';
$lang['reset_password_new_password_label']                    = 'New Password (at least %s characters long):';
$lang['reset_password_new_password_confirm_label']            = 'Confirm New Password:';
$lang['reset_password_submit_btn']                            = 'Change';
$lang['reset_password_validation_new_password_label']         = 'New Password';
$lang['reset_password_validation_new_password_confirm_label'] = 'Confirm New Password';

