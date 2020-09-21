/*TABELA QUE ARMAZENA ARQUIVOS PDF;*/

-- Table: public.tb_arquivo

-- DROP TABLE public.tb_arquivo;

CREATE TABLE public.tb_arquivo
(
    id_pdf serial,
    arquivo character varying(40) COLLATE pg_catalog."default" NOT NULL
)

TABLESPACE pg_default;

ALTER TABLE public.tb_arquivo
    OWNER to postgres;		


		
-- TABELA QUE ARMAZENA REGISTRO DAS MARCAS		

-- Table: public.tb_marca

-- DROP TABLE public.tb_marca;

CREATE TABLE public.tb_marca
(
    id_marca serial,
    tx_marca character varying(80) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT pk_marca PRIMARY KEY (id_marca),
    CONSTRAINT unique_tx_marca UNIQUE (tx_marca)
)

TABLESPACE pg_default;

ALTER TABLE public.tb_marca
    OWNER to postgres;
		
-- TABELA QUE ARMAZENA REGISTROS DOS PATRIMONIOS
		
-- Table: public.tb_patrimonio

-- DROP TABLE public.tb_patrimonio;

CREATE TABLE public.tb_patrimonio
(
    id_tombo serial,
    id_marca integer NOT NULL,
    descricao character varying(120) COLLATE pg_catalog."default" NOT NULL,
    tx_marca character varying(120) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT id_tombo PRIMARY KEY (id_tombo),
    CONSTRAINT fk_marca FOREIGN KEY (id_marca)
        REFERENCES public.tb_marca (id_marca) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE RESTRICT
)

TABLESPACE pg_default;

ALTER TABLE public.tb_patrimonio
    OWNER to postgres;