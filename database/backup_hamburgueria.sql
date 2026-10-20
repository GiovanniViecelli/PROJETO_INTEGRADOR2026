--
-- PostgreSQL database dump
--

\restrict APjwqWWXd1XgWOZgoWIuS5h1Fen838E9dd7xlwNBbnIsR9leQMovDolC7gbkd0X

-- Dumped from database version 18.4 (Ubuntu 18.4-0ubuntu0.26.04.1)
-- Dumped by pg_dump version 18.4 (Ubuntu 18.4-0ubuntu0.26.04.1)

-- Started on 2026-10-20 17:07:53 UTC

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 222 (class 1259 OID 24799)
-- Name: lanches; Type: TABLE; Schema: public; Owner: hamburgueria
--

CREATE TABLE public.lanches (
    id integer NOT NULL,
    nome character varying(100) NOT NULL,
    descricao text,
    preco numeric(10,2) NOT NULL,
    foto character varying(255)
);


ALTER TABLE public.lanches OWNER TO hamburgueria;

--
-- TOC entry 221 (class 1259 OID 24798)
-- Name: lanches_id_seq; Type: SEQUENCE; Schema: public; Owner: hamburgueria
--

CREATE SEQUENCE public.lanches_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.lanches_id_seq OWNER TO hamburgueria;

--
-- TOC entry 3508 (class 0 OID 0)
-- Dependencies: 221
-- Name: lanches_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: hamburgueria
--

ALTER SEQUENCE public.lanches_id_seq OWNED BY public.lanches.id;


--
-- TOC entry 224 (class 1259 OID 24811)
-- Name: pedidos; Type: TABLE; Schema: public; Owner: hamburgueria
--

CREATE TABLE public.pedidos (
    id integer NOT NULL,
    usuario_id integer NOT NULL,
    lanche_id integer NOT NULL,
    quantidade integer DEFAULT 1 NOT NULL,
    status character varying(30) DEFAULT 'pendente'::character varying NOT NULL,
    data_pedido timestamp without time zone DEFAULT now()
);


ALTER TABLE public.pedidos OWNER TO hamburgueria;

--
-- TOC entry 223 (class 1259 OID 24810)
-- Name: pedidos_id_seq; Type: SEQUENCE; Schema: public; Owner: hamburgueria
--

CREATE SEQUENCE public.pedidos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pedidos_id_seq OWNER TO hamburgueria;

--
-- TOC entry 3509 (class 0 OID 0)
-- Dependencies: 223
-- Name: pedidos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: hamburgueria
--

ALTER SEQUENCE public.pedidos_id_seq OWNED BY public.pedidos.id;


--
-- TOC entry 220 (class 1259 OID 24787)
-- Name: usuarios; Type: TABLE; Schema: public; Owner: hamburgueria
--

CREATE TABLE public.usuarios (
    id integer NOT NULL,
    email character varying(100) NOT NULL,
    senha character varying(100) NOT NULL
);


ALTER TABLE public.usuarios OWNER TO hamburgueria;

--
-- TOC entry 219 (class 1259 OID 24786)
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: hamburgueria
--

CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuarios_id_seq OWNER TO hamburgueria;

--
-- TOC entry 3510 (class 0 OID 0)
-- Dependencies: 219
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: hamburgueria
--

ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;


--
-- TOC entry 3335 (class 2604 OID 24802)
-- Name: lanches id; Type: DEFAULT; Schema: public; Owner: hamburgueria
--

ALTER TABLE ONLY public.lanches ALTER COLUMN id SET DEFAULT nextval('public.lanches_id_seq'::regclass);


--
-- TOC entry 3336 (class 2604 OID 24814)
-- Name: pedidos id; Type: DEFAULT; Schema: public; Owner: hamburgueria
--

ALTER TABLE ONLY public.pedidos ALTER COLUMN id SET DEFAULT nextval('public.pedidos_id_seq'::regclass);


--
-- TOC entry 3334 (class 2604 OID 24790)
-- Name: usuarios id; Type: DEFAULT; Schema: public; Owner: hamburgueria
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);


--
-- TOC entry 3500 (class 0 OID 24799)
-- Dependencies: 222
-- Data for Name: lanches; Type: TABLE DATA; Schema: public; Owner: hamburgueria
--

COPY public.lanches (id, nome, descricao, preco, foto) FROM stdin;
1	X-Burger	Pão, hambúrguer, queijo e salada \r\n\r\n\r\n\r\n	18.90	6ad754dc3a2c2.png
2	X-Bacon	Pão, hambúrguer, queijo, bacon e salada	22.50	6ad7558607615.png
5	X-TUDO 	Carne bovina, ovo frito, queijo mussarela, tomate, alface, bacon, cebola.	32.50	6ad755d64b5d7.png
6	X-Tudao	Tudo e mais um pouquinho	47.00	6ad756f859637.png
9	X-Jorge	Tem sabor linux e php	60.00	6ad77601c7453.png
11	X-Platini	Tem gosto de arduínos e bancos de dados	61.00	6ad7760bb7890.png
8	COMBO COCA+FRITAS	Com apenas mais 7 reais, voce adiciona o combo de coca cola e fritas (VALIDO PARA QUALQUER LANCHE).	7.00	6ad77a17c9da0.png
7	x-frango	pao, frango, queijo,  alface, cebola roxa e picles	25.00	6ad77a7e0e864.png
10	X-Morato	Tem gosto de python e bitcoin	60.00	6ad775e4ac92e.png
\.


--
-- TOC entry 3502 (class 0 OID 24811)
-- Dependencies: 224
-- Data for Name: pedidos; Type: TABLE DATA; Schema: public; Owner: hamburgueria
--

COPY public.pedidos (id, usuario_id, lanche_id, quantidade, status, data_pedido) FROM stdin;
\.


--
-- TOC entry 3498 (class 0 OID 24787)
-- Dependencies: 220
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: hamburgueria
--

COPY public.usuarios (id, email, senha) FROM stdin;
1	giovanni@gmail.com	12345
2	ggg@gmail	12345
3	giovanni@giovanni	Gi.091009
4	teste@email.com	123456
5	g@g	1234
\.


--
-- TOC entry 3511 (class 0 OID 0)
-- Dependencies: 221
-- Name: lanches_id_seq; Type: SEQUENCE SET; Schema: public; Owner: hamburgueria
--

SELECT pg_catalog.setval('public.lanches_id_seq', 13, true);


--
-- TOC entry 3512 (class 0 OID 0)
-- Dependencies: 223
-- Name: pedidos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: hamburgueria
--

SELECT pg_catalog.setval('public.pedidos_id_seq', 1, false);


--
-- TOC entry 3513 (class 0 OID 0)
-- Dependencies: 219
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: hamburgueria
--

SELECT pg_catalog.setval('public.usuarios_id_seq', 5, true);


--
-- TOC entry 3345 (class 2606 OID 24809)
-- Name: lanches lanches_pkey; Type: CONSTRAINT; Schema: public; Owner: hamburgueria
--

ALTER TABLE ONLY public.lanches
    ADD CONSTRAINT lanches_pkey PRIMARY KEY (id);


--
-- TOC entry 3347 (class 2606 OID 24824)
-- Name: pedidos pedidos_pkey; Type: CONSTRAINT; Schema: public; Owner: hamburgueria
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_pkey PRIMARY KEY (id);


--
-- TOC entry 3341 (class 2606 OID 24797)
-- Name: usuarios usuarios_email_key; Type: CONSTRAINT; Schema: public; Owner: hamburgueria
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_email_key UNIQUE (email);


--
-- TOC entry 3343 (class 2606 OID 24795)
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: hamburgueria
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- TOC entry 3348 (class 2606 OID 24830)
-- Name: pedidos pedidos_lanche_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: hamburgueria
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_lanche_id_fkey FOREIGN KEY (lanche_id) REFERENCES public.lanches(id);


--
-- TOC entry 3349 (class 2606 OID 24825)
-- Name: pedidos pedidos_usuario_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: hamburgueria
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES public.usuarios(id);


-- Completed on 2026-10-20 17:07:56 UTC

--
-- PostgreSQL database dump complete
--

\unrestrict APjwqWWXd1XgWOZgoWIuS5h1Fen838E9dd7xlwNBbnIsR9leQMovDolC7gbkd0X

