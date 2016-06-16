
/**
 * Author:  gonzalo
 * Created: 23-03-2016
 * Description: parche Sql para agregar default a id de tablas
 */

alter table usuario alter column id set default nextval('usuario_id_seq'::regclass);

alter table contacto alter column id set default nextval('contacto_id_seq'::regclass);

alter table contenido alter column id set default nextval('contenido_id_seq'::regclass);

alter table datos_verant alter column id set default nextval('datos_verant_id_seq'::regclass);

alter table empresa alter column id set default nextval('empresa_id_seq'::regclass);

alter table faq alter column id set default nextval('faq_id_seq'::regclass);

alter table horario alter column id set default nextval('horario_id_seq'::regclass);

alter table pregunta alter column id set default nextval('pregunta_id_seq'::regclass);


